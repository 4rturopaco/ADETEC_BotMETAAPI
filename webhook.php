<?php
const TOKEN_ADETEC = "ADETECCODEPHPAPIMETA";
const WEBHOOK_URL = "https//whatsappapi.adetec-it.website/webhook.php";

function verificarToken($req, $res)
{
    try {
        $token = $req['hub_verify_token'];
        $challenge = $req['hub_challenge'];

        if (isset($challenge) && isset($token) && $token === TOKEN_ADETEC) {
            $res->send($challenge);
        } else {
            $res->status(400)->send();
        }
    } catch (Exception $e) {
        $res->status(400)->send();
    }
}

function recibirMensajes($req, $res)
{

    try {

        $entry = $req['entry'][0];
        $changes = $entry['changes'][0];
        $value = $changes['value'];
        $mensaje = $value['messages'][0];

        $comentario = $mensaje['text']['body'];
        $numero = $mensaje['from'];

        $id = $mensaje['id'];

        $archivo = "log.txt";

        if (!verificarTextoEnArchivo($id, $archivo)) {
            $archivo = fopen($archivo, "a");
            $texto = json_encode($id) . "," . $numero . "," . $comentario;
            fwrite($archivo, $texto);
            fclose($archivo);

            EnviarMensajeWhastapp($comentario, $numero);
        }

        /*$res->header('Content-Type: application/json');
        $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));*/
        echo json_encode(['message' => 'EVENT_RECEIVED']);
        exit;
    } catch (Exception $e) {
        /*$res->header('Content-Type: application/json');
        $res->status(200)->send(json_encode(['message' => 'EVENT_RECEIVED']));*/
        echo json_encode(['message' => 'EVENT_RECEIVED']);
        exit;
    }
}

function EnviarMensajeWhastapp($comentario, $numero)
{
    $comentario = strtolower($comentario);

    if (strpos($comentario, 'hola') !== false) {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "👋 ¡Hola! Gracias por escribir a *ADETEC*\n\n 🤖 Soy tu asistente virtual y puedo ayudarte de inmediato."
            ]
        ]);
    } else if ($comentario == '1') {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "💻 Desarrollo Web *ADETEC*\n\n_Creamos soluciones digitales a medida para tu negocio:_\n🌐 Páginas web corporativas\n🛒 Tiendas online (e-commerce)\n🚀 Landing pages para ventas\n🔧 Mantenimiento y optimización web\n\n💡 Todos nuestros sitios incluyen diseño moderno, adaptables a celular y optimizados para Google.\n\n👉 ¿Qué tipo de web necesitas? Escríbenos o solicita una cotización 👇"
            ]
        ]);
    } else if ($comentario == '2') {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "📹 *Sistemas de Seguridad CCTV*\n\n Protege tu hogar o negocio con nuestros servicios:\n\n🔒 Instalación de cámaras de seguridad\n📱 Monitoreo desde tu celular\n🛠️ Mantenimiento y soporte técnico\n🎯 Soluciones personalizadas según tu necesidad\n💡 Trabajamos con equipos de alta calidad y asesoramiento profesional.\n\n👉 ¿Cuántas cámaras necesitas o qué área deseas cubrir? Te cotizamos sin compromiso 👇"
            ]
        ]);
    } else if ($comentario == '3') {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "🌐 *Redes e Infraestructura*\n\n Optimiza la conectividad y seguridad de tu empresa:\n\n🔌 Instalación de redes LAN y WiFi\n🖥️ Configuración de servidores\n🔐 Seguridad informática (Firewall / VPN)\n☁️ Implementación de nube y almacenamiento\n💡 Garantizamos estabilidad, velocidad y seguridad en tu red.\n\n👉 Cuéntanos tu requerimiento y te ayudamos con la mejor solución 👇"
            ]
        ]);
    } else if ($comentario == '4') {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "🛠️ *Soporte Técnico ADETEC*\n\n Solucionamos tus problemas tecnológicos de forma rápida y eficiente:\n\n💻 Mantenimiento de computadoras\n🐢 Equipos lentos o con fallas\n🖨️ Configuración de impresoras\n🌐 Problemas de red\n🧑‍💻 Soporte remoto y presencial\n💡 Atención para empresas y particulares.\n\n👉 Describe tu problema y te ayudamos de inmediato 👇"
            ]
        ]);
    } else if ($comentario == '5') {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "📞 *Atención Personalizada*\n\n Uno de nuestros asesores especializados te ayudará con tu requerimiento.\n⏳ Tiempo de respuesta: lo antes posible\n💬 Atención clara, rápida y profesional\n\n👉 Por favor escribe tu consulta y en breve te responderemos ó ingresa al siguiente enlace para que puedas ser atendido 👇\n https://wa.me/59162412570"
            ]
        ]);
    } else if ($comentario == '6') {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "🕒 *Horario de Atención ADETEC*\n\n Estamos disponibles para ayudarte en los siguientes horarios:\n 📅 Lunes a Viernes\n🕘 08:30 – 18:30\n\n📅 Sábados\n🕘 09:00 – 13:00\n\n❌ Domingos y feriados: Cerrado\n 💡 Si nos escribes fuera de horario, no te preocupes 😉\n\nTe responderemos a primera hora del siguiente día hábil.\n👉 ¿Deseas que un asesor te contacte? Escríbenos tu consulta 👇"
            ]
        ]);
    } else if (strpos($comentario, 'adios') !== false || strpos($comentario, 'hasta luego') !== false || strpos($comentario, 'gracias') !== false || strpos($comentario, 'adi')) {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "🙏 _¡Gracias por contactarte con ADETEC!_\n\n Ha sido un gusto ayudarte 😊\n Si necesitas más información o soporte, estaremos atentos para asistirte. \n🚀 ¡Que tengas un excelente día!"
            ]
        ]);
    } else {
        $data = json_encode([
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $numero,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "🚀 Hola, bienvenido a *ADETEC*.\n \n Soy tu asistente virtual 🤖\n ¿En qué puedo ayudarte?\n \n1️⃣. Desarrollo Web 💻\n2️⃣. Cámaras de Seguridad (CCTV) 📹\n3️⃣. Redes e Infraestructura 🌐\n4️⃣. Soporte Técnico 🛠️\n5️⃣. Hablar con un asesor 📞\n6️⃣. Horario de Atención. 🕜\n \nEscribe el número de la opción 👇 "
            ]
        ]);
    }

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-type: application/json\r\nAuthorization: Bearer EAAZC8If3ZAekUBRSe03MF1rFZC6xZC21nZB7iVMPHkWaEuYZAMriB2UyL1WH7gsiJc58nGBnR7GmDGYhFiHHeVFmgqAd7EKf31OhnJZAtfwzLX00nZB12k8vdQaDAZATZCXkEWJwMnLV2sHmoqb3sXF29bk5MTGqZBjoKr0eZCZBwlPuj3UbF9yT84BC7A59s7EN3lcez9k9uHVe73vtXzzJt1i2IsFU52EMcMnYJZBBuHIt7dOZCO9A7xdPPmJVSGO3knv8j1PqJQPl6bKCpGGQ8qcw0FbgQtfCwdLzwOScwZDZD\r\n",
            'content' => $data,
            'ignore_errors' => true
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents('https://graph.facebook.com/v25.0/450724384799151/messages', false, $context);

    if ($response === false) {
        echo "Error al enviar el mensaje\n";
        exit;
    } else {
        echo "Mensaje enviado correctamente\n";
        exit;
    }
}

function verificarTextoEnArchivo($texto, $archivo)
{
    $contenido = file_get_contents($archivo);

    if (strpos($contenido, $texto) !== false) {
        return true; // El texto ya existe en el archivo
    } else {
        return false; // El texto no existe en el archivo
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    recibirMensajes($data, http_response_code());
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['hub_mode']) && isset($_GET['hub_verify_token']) && isset($_GET['hub_challenge']) && $_GET['hub_mode'] === 'subscribe' && $_GET['hub_verify_token'] === TOKEN_ADETEC) {
        echo $_GET['hub_challenge'];
    } else {
        http_response_code(403);
    }
}
?>

//CLASE 22 PARA CONTINUAR