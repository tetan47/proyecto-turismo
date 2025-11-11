from flask import Flask, request, jsonify
from flask_cors import CORS
import datetime

app = Flask(__name__)
CORS(app)

palabras_prohibidas = [
    "tonto", "idiota", "estúpido", "perdedor",
    "basura", "matar", "puto", "mierda",
    "culiao", "pelotudo", "forro", "boludo", "conchudo", "hdp", "desgraciado",
    "baboso", "gilipollas", "cagón", "maricón", "pendejo", "huevón",
    "weón", "conchesumadre", "reculiao", "pijas", "cornudo", "fracasado",
    "imbécil", "retrasado", "subnormal", "violador", "pedófilo", "nigga", "mogolico",
    "bolita", "estupido", "gorreado", "gordo", "termotanque de rabioles", "peruano"
]

def moderar_comentario(texto):
    texto_lower = texto.lower().strip()
    if len(texto_lower) == 0:
        return False, "El comentario no puede estar vacío."
    if len(texto) > 300:
        return False, "El comentario es demasiado largo (máx. 300 caracteres)."
    if texto.isupper() and len(texto) > 10:
        return False, "No uses mayúsculas para gritar."
    for palabra in palabras_prohibidas:
        if palabra in texto_lower:
            return False, f"Lenguaje inapropiado detectado: '{palabra}'. Reformula tu comentario."
    return True, "Comentario aprobado."

@app.route('/moderacion', methods=['POST'])
def moderar():
    data = request.form
    texto = data.get('texto', '').strip()
    if not texto:
        return jsonify({'aprobado': False, 'mensaje': 'Texto vacío.'})
    aprobado, mensaje = moderar_comentario(texto)
    with open('historial_moderacion.txt', 'a', encoding='utf-8') as f:
        hora = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        f.write(f"[{hora}] {texto} → {'APROBADO' if aprobado else 'RECHAZADO: ' + mensaje}\n")
    return jsonify({'aprobado': aprobado, 'mensaje': mensaje})

if __name__ == '__main__':
    print("moderacion activa en http://localhost:5000")
    app.run(host='127.0.0.1', port=5000, debug=True)