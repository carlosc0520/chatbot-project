'use strict';

const axios = require('axios');
const functions = require('firebase-functions');
const { WebhookClient } = require('dialogflow-fulfillment');
const { Card, Suggestion } = require('dialogflow-fulfillment');
const language = require('@google-cloud/language');

// Inicializar el cliente de Natural Language
const client = new language.LanguageServiceClient();

process.env.DEBUG = 'dialogflow:debug'; // enables lib debugging statements

// Función de bienvenida
function welcome(agent) {
    agent.add(`¡Bienvenido a mi agente!`);
}

// Función de fallback
function fallback(agent) {
    agent.add(`No he entendido tu solicitud.`);
    agent.add(`Lo siento, ¿puedes intentarlo de nuevo?`);
}

// Función para calcular la distancia de Levenshtein entre dos cadenas
function levenshteinDistance(str1, str2) {
    const m = str1.length;
    const n = str2.length;
    const dp = [];

    for (let i = 0; i <= m; i++) {
        dp[i] = [i];
    }
    for (let j = 0; j <= n; j++) {
        dp[0][j] = j;
    }

    for (let i = 1; i <= m; i++) {
        for (let j = 1; j <= n; j++) {
            const cost = str1[i - 1] === str2[j - 1] ? 0 : 1;
            dp[i][j] = Math.min(
                dp[i - 1][j] + 1,
                dp[i][j - 1] + 1,
                dp[i - 1][j - 1] + cost
            );
        }
    }

    return dp[m][n];
}

// Función para encontrar la coincidencia más cercana entre el nombre proporcionado y los nombres en la base de datos
function encontrarCoincidenciaMasCercana(nombreProporcionado, nombresBaseDatos) {
    let mejorCoincidencia = '';
    let mejorDistancia = Infinity;

    nombresBaseDatos.forEach(nombre => {
        const distancia = levenshteinDistance(nombreProporcionado, nombre);
        if (distancia < mejorDistancia) {
            mejorDistancia = distancia;
            mejorCoincidencia = nombre;
        }
    });

    return mejorCoincidencia;
}

// Función para obtener la fecha de fin de clases para el ciclo proporcionado
function obtenerFechaFinClases(ciclo) {
    const finClasesPorCiclo = {
        '2024-01': '19 de julio de 2024',
        '2024-02': '18 de diciembre de 2024',
        'Verano': '28 de febrero de 2024'
    };

    // Buscar la mejor coincidencia para el ciclo proporcionado
    const mejorCoincidencia = encontrarCoincidenciaMasCercana(ciclo, Object.keys(finClasesPorCiclo));

    // Obtener la fecha de fin de clases correspondiente a la mejor coincidencia
    const fechaFinClases = finClasesPorCiclo[mejorCoincidencia];

    return fechaFinClases || null;
}

// Función de manejo de la intención "FinClases"
function finClasesHandler(agent) {
    const ciclo = agent.parameters.Ciclo;
    const fechaFinClases = obtenerFechaFinClases(ciclo);

    if (fechaFinClases) {
        agent.add(`El fin de clases del período ${ciclo} es el ${fechaFinClases}.`);
    } else {
        agent.add(`Lo siento, no tengo información sobre el fin de clases para el ${ciclo}.`);
    }
}

function obtenerFechaExamenesFinales(ciclo) {
    const examenesFinalesPorCiclo = {
        'Verano': 'No se tienen exámenes finales',
        '2024-01': 'Del 3 al 9 de julio de 2024',
        '2024-02': 'Del 2 al 7 de diciembre de 2024'
    };

    // Buscar la mejor coincidencia para el ciclo proporcionado
    const mejorCoincidencia = encontrarCoincidenciaMasCercana(ciclo, Object.keys(examenesFinalesPorCiclo));

    // Obtener la fecha de exámenes finales correspondiente a la mejor coincidencia
    const fechaExamenesFinales = examenesFinalesPorCiclo[mejorCoincidencia];

    return fechaExamenesFinales || null;
}

// Función de manejo de la intención "ExámenesFinales"
function examenesFinalesHandler(agent) {
    const ciclo = agent.parameters.Ciclo;
    const fechaExamenesFinales = obtenerFechaExamenesFinales(ciclo);

    if (fechaExamenesFinales) {
        agent.add(`Los exámenes finales para el perído ${ciclo}, es en la fecha ${fechaExamenesFinales}.`);
    } else {
        agent.add(`Lo siento, no tengo información sobre los exámenes finales para el período ${ciclo}.`);
    }
}

function matricularSinInglesHandler(agent) {
    agent.add(`No, el curso de inglés es obligatorio para cada ciclo de matrícula.`);
}

function solicitudAperturaBloqueHandler(agent) {
    // Obtener el curso proporcionado por el usuario desde los parámetros de la entidad
    const curso = agent.parameters.Curso;

    // Respuesta al usuario indicando que debe comunicarse con la coordinación de su carrera
    agent.add(`Para poder realizar su solicitud de apertura de bloque para el curso "${curso}", debe comunicarse con la coordinación de su carrera. Puede revisar los anexos en el siguiente enlace: [Enlace a los anexos](https://example.com/anexos).`);

    // Si deseas, también puedes proporcionar sugerencias adicionales al usuario
    // agent.add(new Suggestion('¿Cómo puedo contactar a la coordinación?'));
}

async function analyzeSentiment(text) {
    const document = {
        content: text,
        type: 'PLAIN_TEXT',
    };

    const [result] = await client.analyzeSentiment({document});
    const sentiment = result.documentSentiment;
    console.log(`Sentimiento: ${sentiment.score}`);
    console.log(`Magnitud: ${sentiment.magnitude}`);
    
    return sentiment;
}

// Función de manejo de la intención "Saludo"
function saludoHandler(agent) {
    // Obtener el texto del usuario
    const textoUsuario = agent.query;

    // Analizar el sentimiento del texto del usuario
    analyzeSentiment(textoUsuario).then(sentiment => {
        // Basado en el sentimiento, generar una respuesta personalizada
        if (sentiment.score < 0) {
            agent.add(`Parece que no estás teniendo un buen día. ¿Cómo puedo ayudarte?`);
        } else {
            agent.add(`¡Hola! ¿En qué puedo ayudarte hoy?`);
        }
    }).catch(error => {
        console.error('Error al analizar el sentimiento:', error);
        agent.add(`Lo siento, ha ocurrido un error.`);
    });
}

// Configuración de las intenciones y sus respectivas funciones de manejo
const intentMap = new Map();
intentMap.set('Default Welcome Intent', welcome);
intentMap.set('Default Fallback Intent', fallback);
intentMap.set('FinClases', finClasesHandler);
intentMap.set('ExamenesFinales', examenesFinalesHandler);
intentMap.set('MatricularSinIngles', matricularSinInglesHandler);
intentMap.set('AperturaBloqueCurso', solicitudAperturaBloqueHandler);
intentMap.set('Saludo', saludoHandler);

// Manejar las solicitudes del agente de Dialogflow
exports.dialogflowFirebaseFulfillment = functions.https.onRequest((request, response) => {
    const agent = new WebhookClient({ request, response });
    console.log('Request headers: ' + JSON.stringify(request.headers));
    console.log('Request body: ' + JSON.stringify(request.body));
    agent.handleRequest(intentMap);
});
