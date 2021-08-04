import Echo from "laravel-echo";
import Pusher from "pusher-js";

const client = new Pusher(process.env.REACT_APP_WEBSOCKET_SERVER_KEY, {
    wsHost: process.env.REACT_APP_MAIN_SERVER_URL,
    wsPort: process.env.REACT_APP_WEBSOCKET_SERVER_PORT,
    cluster: process.env.PUSHER_APP_CLUSTER,
    forceTLS: false
});

export const Websockets = new Echo({
    broadcaster: 'pusher',
    client
});
