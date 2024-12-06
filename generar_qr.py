import qrcode
import json
import sys

def generar_qr(archivo_json, archivo_qr):
    try:
        # Leer los metadatos desde el archivo JSON
        with open(archivo_json, 'r') as f:
            metadatos = json.load(f)

        # Convertir metadatos a texto para el QR
        texto_qr = json.dumps(metadatos, indent=2)

        # Generar el QR
        qr = qrcode.QRCode(
            version=1,
            error_correction=qrcode.constants.ERROR_CORRECT_L,
            box_size=10,
            border=4,
        )
        qr.add_data(texto_qr)
        qr.make(fit=True)

        # Guardar la imagen del QR
        img = qr.make_image(fill_color="black", back_color="white")
        img.save(archivo_qr)

        print(f"QR generado en: {archivo_qr}")
    except Exception as e:
        print(f"Error generando el QR: {e}", file=sys.stderr)

# Entrada: archivo JSON y salida para el QR
if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Uso: python generar_qr.py <archivo_json> <archivo_qr>")
        sys.exit(1)

    archivo_json = sys.argv[1]
    archivo_qr = sys.argv[2]

    generar_qr(archivo_json, archivo_qr)
