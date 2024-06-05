let socket = new WebSocket('wss://spartiates-socket-server.glitch.me/');

socket.addEventListener('open', (event) => {
    console.log('Connexion WebSocket ouverte:', event);

    $.ajax({
        type: "POST",
        url: "/index.php",
        data: {
            action: "connexionWS",
        },
    }).done(function (response) {
        socket.send(response);
    });

});

let messageMapping = [
    "stop",
    "start",
    // "reset",
];

socket.addEventListener('message', (event) => {
    console.log('Message reçu:', event.data);
    const message = event.data;
    if (messageMapping.includes(message)) {
        console.log('recu', message);
        if (typeof window.endGame === 'function')
            console.log('endGame', window.endGame);
            window.endGame(message);
    } else {
        WSRanking(message);
    }
});

socket.addEventListener('close', (event) => {
    console.log('Connexion WebSocket fermée:', event);
});

function sendMessage(message) {
    if (message === "stop" || message === "start") {
        const JsonMessage = {
            action: 'resetScore',
        };
        socket.send(JSON.stringify(JsonMessage));
        $.ajax({
            type: "POST",
            url: "/index.php",
            data: {
                action: message,
            },
        }).done(function (response) {
            $('#code').html(response);
        });
    }

    const JsonMessage = {
        action: 'adminBroadcast',
        message: message,
    };
    socket.send(JSON.stringify(JsonMessage));
}

function sendScore(score) {
    const JsonMessage = {
        action: 'myScore',
        score: score,
    };
    socket.send(JSON.stringify(JsonMessage));
}

function sendIDMessage(message, id) {
    const JsonMessage = {
        action: 'adminMessage',
        id: id,
        message: message,
    };
    socket.send(JSON.stringify(JsonMessage));
}

function WSRanking(message) {
    let ranking = $("#ranking");
    ranking.empty();
// [{"id":"239","score":2600, "pseudo": "JohnDoe"}]
    const messageJson = JSON.parse(message);

    for (let i = 0; i < messageJson.length; i++) {
        let id = messageJson[i].id;
        let score = messageJson[i].score;
        let username = messageJson[i].username;

        // Créer une nouvelle ligne tr avec les données
        let newRow = $('<tr class="bg-white">' +
            '<td class="px-4 py-2 border-t border-b text-center font-bold">' + (i + 1) + '</td>' +
            '<td class="px-4 py-2 border-t border-b text-center">' + username + '</td>' +
            '<td class="px-4 py-2 border-t border-b text-center">' + score + '</td>' +
            '<td class="p-2 border bg-[var(--color-bg)] text-center">' +
            '<button data-id="' + id + '" data-action="deleteUser" class="deleteButton actionButton inline-block w-8 h-8 bg-red-500 hover:bg-red-700 rounded" type="button">' +
            '<img class="p-1" src="/assets/images/icon/trashcan.svg" alt="Delete">' +
            '</button>' +
            '</td>' +
            '</tr>');

        // Ajouter la nouvelle ligne au tableau
        ranking.append(newRow);
    }
}