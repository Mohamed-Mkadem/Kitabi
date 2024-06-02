import Echo from 'laravel-echo'
import Pusher from "pusher-js";
import { showNotification, incrementNotificationsCounter, addTheNewNotificationToTheNotificationsHolder } from './functions.js';

window.Pusher = Pusher


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});


let channel = window.Echo.private('App.Models.User.' + userId);

channel.notification(data => {
    showNotification(data)
    incrementNotificationsCounter()
    if (userId == 1) {
        addTheNewNotificationToTheNotificationsHolder(data)
    }
})

