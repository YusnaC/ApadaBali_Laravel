import { messaging } from './firebase-messaging';
import { getToken, onMessage } from 'firebase/messaging';

class NotificationHandler {
    constructor() {
        this.notifications = [];
        this.unreadCount = 0;
        this.notificationCounter = document.querySelector('notification-counter');
        this.notificationList = document.querySelector('.notification-items');
        
        // Initialize Firebase and setup listeners
        this.initializeFirebase();
        this.setupEventListeners();
        console.log('NotificationHandler initialized');
    }

    handleNewNotification(payload) {
        console.log('New notification received:', payload);
        console.log("this is element notification", document.getElementById('notificationCounter'));
        
        if (payload && (payload.notification || payload.data)) {
            this.unreadCount++;
            const notificationData = payload.notification || payload.data;
            this.notifications.unshift({
                title: notificationData.title,
                body: notificationData.body,
                time: new Date().toLocaleTimeString(),
                read: false
            });
            
            // Update counter and list
            if (this.notificationCounter) {
                this.notificationCounter.textContent = this.unreadCount;
                this.notificationCounter.style.display = 'block';
            }
            
            if (this.notificationList) {
                this.updateNotificationList();
            }
        }
    }

    updateNotificationList() {
        console.log("apakah dia masuk sini?");
        
        if (this.notificationList && this.notifications.length > 0) {
            const notificationHtml = this.notifications.map(notification => `
                <div class="notification-item d-flex align-items-center px-3 py-2 border-bottom">
                    <div class="me-3">
                        <i class="bx bx-bell fs-4 text-warning"></i>
                    </div>
                    <div class="notification-content flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="user-name fw-semibold">${notification.title}</span>
                                <div class="action">${notification.body}</div>
                            </div>
                        </div>
                        <div class="notification-time text-muted small">${notification.time}</div>
                    </div>
                </div>
            `).join('');
            
            this.notificationList.innerHTML = notificationHtml;
        }
    }

    setupEventListeners() {
        // Listen for new messages
        onMessage(messaging, (payload) => {
            console.log('Firebase message received:', payload);
            this.handleNewNotification(payload);
        });

        // Mark all as read
        document.querySelector('.mark-all-read').addEventListener('click', () => {
            this.markAllAsRead();
        });
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
