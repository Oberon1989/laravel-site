// Ссылка на WebSocket сервер


let socket;


// Функция, которая будет вызвана при получении сообщения
function handleMessage(message) {
    console.log("Callback вызван с сообщением:", message);
}

// Функция для подключения к WebSocket серверу
function connectWebSocket(onMessageCallback,url) {
    if (socket) {
        console.log("Уже подключено к WebSocket серверу.");
        return; // Если уже подключено, просто выходим
    }

    socket = new WebSocket(url);

    // Событие при открытии соединения
    socket.onopen = () => {
        console.log('Подключение установлено!');
    };

    // Событие при получении сообщения
    socket.onmessage = (event) => {
        console.log('Сообщение от сервера:', event.data);
        // Здесь вызываем переданный callback (onMessageCallback)
        if (onMessageCallback && typeof onMessageCallback === 'function') {
            onMessageCallback(event.data); // Вызываем callback с данными
        }
    };

    // Событие при закрытии соединения
    socket.onclose = (event) => {
        if (event.wasClean) {
            console.log(`Соединение закрыто чисто (код ${event.code})`);
        } else {
            console.log(`Соединение потеряно (код ${event.code})`);
        }
    };

    // Событие при ошибке соединения
    socket.onerror = (error) => {
        console.error(`Ошибка WebSocket: ${error.message}`);
    };
    window.connectWebSocket = connectWebSocket;
    window.handleMessage = handleMessage;
}






