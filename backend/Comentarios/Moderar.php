<?php

class ModeradorAPI {
    private $apiKey;
    private $apiUrl = 'https://api.openai.com/v1/moderations';
    
    // Umbrales de confianza (0-1, donde 1 es más seguro que sea inapropiado el comentario)
    private $umbralGeneral = 0.5;  // Umbral general para categorías
    
    public function __construct() {
        // Cargar API Key
        require_once(__DIR__ . '/../../config/api-key.php');
        
        if (defined('OPENAI_API_KEY')) {
            $this->apiKey = OPENAI_API_KEY;
        } else {
            $this->apiKey = $OPENAI_API_KEY;
        }
    }
    
    public function moderarTexto($texto) {
        // Validaciones previas
        if (empty(trim($texto))) {
            return [
                'aprobado' => false,
                'razon' => 'El comentario está vacío',
                'categorias' => []
            ];
        }
        
        // Detecta URLs sospechosas
        if ($this->contieneURLsSospechosas($texto)) {
            return [
                'aprobado' => false,
                'razon' => 'El comentario contiene enlaces no permitidos',
                'categorias' => []
            ];
        }
        
        // Detecta patrones de spam
        if ($this->esSpam($texto)) {
            return [
                'aprobado' => false,
                'razon' => 'El comentario parece ser spam',
                'categorias' => []
            ];
        }
        
        // Análisis con OpenAI Moderation API
        $analisisAPI = $this->analizarConOpenAI($texto);
        
        if (!$analisisAPI['exito']) {
            // Si falla la API, aplicar filtro local básico
            return $this->moderacionLocal($texto);
        }
        
        // Evaluar resultado de OpenAI
        $resultado = $analisisAPI['resultado'];
        
        // Si OpenAI marca como flagged, rechazar
        if ($resultado['flagged']) {
            $categorias = $this->obtenerCategoriasActivas($resultado['categories']);
            return [
                'aprobado' => false,
                'razon' => 'El comentario contiene contenido inapropiado: ' . implode(', ', $categorias),
                'categorias' => $resultado['categories']
            ];
        }
        
        // Comentario aprobado
        return [
            'aprobado' => true,
            'razon' => 'Comentario aprobado',
            'categorias' => $resultado['categories']
        ];
    }
    
    /* Llamada a OpenAI Moderation API */
    private function analizarConOpenAI($texto) {
        $data = [
            'input' => $texto
        ];
        
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($httpCode !== 200 || !$response || $error) {
            error_log("Error en OpenAI Moderation API: HTTP $httpCode - $error");
            return ['exito' => false];
        }
        
        $resultado = json_decode($response, true);
        
        if (!isset($resultado['results']) || !isset($resultado['results'][0])) {
            return ['exito' => false];
        }
        
        return [
            'exito' => true,
            'resultado' => $resultado['results'][0]
        ];
    }
    
    /* Obtener nombres de categorías que fueron marcadas */
    private function obtenerCategoriasActivas($categories) {
        $nombresCategoriasES = [
            'hate' => 'odio',
            'hate/threatening' => 'amenazas de odio',
            'harassment' => 'acoso',
            'harassment/threatening' => 'acoso amenazante',
            'self-harm' => 'autolesión',
            'self-harm/intent' => 'intención de autolesión',
            'self-harm/instructions' => 'instrucciones de autolesión',
            'sexual' => 'contenido sexual',
            'sexual/minors' => 'contenido sexual con menores',
            'violence' => 'violencia',
            'violence/graphic' => 'violencia gráfica'
        ];
        
        $activas = [];
        foreach ($categories as $categoria => $valor) {
            if ($valor) {
                $activas[] = $nombresCategoriasES[$categoria] ?? $categoria;
            }
        }
        
        return $activas;
    }
    
    /* Detecta URLs sospechosas o no permitidas */
    private function contieneURLsSospechosas($texto) {
        // Patrones de URLs
        $patronesURL = [
            '/https?:\/\/[^\s]+/i',
            '/www\.[^\s]+/i',
            '/[a-z0-9-]+\.(com|net|org|info|biz|xyz|tk|ml|ga|cf|gq)[^\s]*/i'
        ];
        
        // Páginas Web permitidas mencionar dentro de los comentarios
        $dominiosPermitidos = [
            'youtube.com',
            'youtu.be',
            'instagram.com',
            'facebook.com',
            'twitter.com',
            'tiktok.com',
            'spotify.com',
            'imgur.com'
        ];
        
        foreach ($patronesURL as $patron) {
            if (preg_match_all($patron, $texto, $matches)) {
                foreach ($matches[0] as $url) {
                    $esPermitido = false;
                    foreach ($dominiosPermitidos as $dominio) {
                        if (stripos($url, $dominio) !== false) {
                            $esPermitido = true;
                            break;
                        }
                    }
                    if (!$esPermitido) {
                        return true; // Se encontró una URL sospechosa
                    }
                }
            }
        }
        
        return false;
    }
    
    /* Detecta patrones de spam */
    private function esSpam($texto) {
        $textoLower = mb_strtolower($texto, 'UTF-8');
        
        // Patrones de spam comunes
        $patronesSpam = [
            '/gana dinero/i',
            '/click aqui/i',
            '/click here/i',
            '/visitanos en/i',
            '/visita nuestra web/i',
            '/compra ahora/i',
            '/oferta limitada/i',
            '/oferta exclusiva/i',
            '/!!!!!+/',
            '/\$\$\$+/',
            '/€€€+/',
            '/premio garantizado/i',
            '/descarga gratis/i',
            '/sin costo/i'
        ];
        
        foreach ($patronesSpam as $patron) {
            if (preg_match($patron, $texto)) {
                return true;
            }
        }
        
        // Detecta la repetición excesiva de caracteres no importa cual
        if (preg_match('/(.)\1{10,}/', $texto)) {
            return true;
        }
        
        // Detecta si es casi todo mayúsculas
        $mayusculas = preg_match_all('/[A-ZÁÉÍÓÚÑ]/', $texto);
        $letras = preg_match_all('/[a-zA-ZáéíóúñÁÉÍÓÚÑ]/', $texto);
        if ($letras > 20 && ($mayusculas / $letras) > 0.7) {
            return true;
        }
        
        return false;
    }
    

    private function moderacionLocal($texto) {
        $palabrasProhibidas = [
            'idiota', 'estupido', 'estúpido', 'imbecil', 'imbécil', 
            'pendejo', 'cabron', 'cabrón', 'mierda', 'puta', 'puto', 
            'joder', 'carajo', 'hdp', 'hijo de puta', 'boludo', 
            'pelotudo', 'tarado', 'retrasado', 'marica', 'maricon',
            'maricón', 'perra', 'zorra', 'cojones', 'coño', 'verga',
            'chingar', 'malparido', 'gonorrea', 'hijueputa'
        ];
        
        $textoLower = mb_strtolower($texto, 'UTF-8');
        
        foreach ($palabrasProhibidas as $palabra) {
            // Busca y detecta la palabra completa (si es que la encuentra y no como parte de otra palabra)
            $patron = '/\b' . preg_quote($palabra, '/') . '\b/iu';
            if (preg_match($patron, $textoLower)) {
                return [
                    'aprobado' => false,
                    'razon' => 'El comentario contiene lenguaje inapropiado',
                    'categorias' => []
                ];
            }
        }
        
        return [
            'aprobado' => true,
            'razon' => 'Comentario aprobado (verificación local)',
            'categorias' => []
        ];
    }
    
    /* Purifica el texto para prevenir XSS(Scripts o iyecciones de comandos) */
    public function sanitizarTexto($texto) {
        // Eliminar tags HTML
        $texto = strip_tags($texto);
        
        // Convertir entidades HTML
        $texto = htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
        
        // Eliminar caracteres de control
        $texto = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $texto);
        
        // Limitar longitud
        if (strlen($texto) > 1000) {
            $texto = substr($texto, 0, 1000);
        }
        
        return trim($texto);
    }
}
?>