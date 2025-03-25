import { messaging } from './firebase-messaging';
import { getToken, onMessage } from 'firebase/messaging';

class NotificationHandler {
    constructor() {
        this.notificationCounter = document.querySelector('.notification-counter');
        this.notificationList = document.querySelector('.notification-items');
        this.unreadCount = 0;
        this.notifications = [];
        
        this.initializeFirebase();
        this.setupEventListeners();
    }

    async initializeFirebase() {
        try {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                const token = await getToken(messaging, {
                    vapidKey: 'BDbzKpYdkjEeUhGuXFl2QIP0CKIqUi0cb0MKBIb8BwJ5Tdc9YXgs4MqUQVGWYLAuW80IUqZI5byUjJJj0bDnz0Y'
                });
                
                // Send token to your Laravel backend
                await fetch('/api/save-device-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ token })
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    setupEventListeners() {
        // Listen for new messages
        onMessage(messaging, (payload) => {
            this.handleNewNotification(payload);
        });

        // Mark all as read
        document.querySelector('.mark-all-read').addEventListener('click', () => {
            this.markAllAsRead();
        });
    }

    handleNewNotification(payload) {
        this.unreadCount++;
        this.notifications.unshift(payload.data);
        this.updateNotificationCounter();
        this.updateNotificationList();
    }

    updateNotificationCounter() {
        this.notificationCounter.textContent = this.unreadCount;
        this.notificationCounter.style.display = this.unreadCount > 0 ? 'block' : 'none';
    }

    updateNotificationList() {
        this.notificationList.innerHTML = this.notifications.map(notification => `
           
        `).join('');
    }

    markAllAsRead() {
        this.unreadCount = 0;
        this.notifications.forEach(notification => notification.read = true);
        this.updateNotificationCounter();
        this.updateNotificationList();
    }
}

// Initialize notifications when document is ready
document.addEventListener('DOMContentLoaded', () => {
    new NotificationHandler();
});