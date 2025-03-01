import './bootstrap';

import Alpine from 'alpinejs';

import { createApp } from 'laravel-vite-plugin'
import { Film, Users, MessageSquare, Home } from 'lucide'

createApp()
    .component('lucide-film', Film)
    .component('lucide-users', Users)
    .component('lucide-message-square', MessageSquare)
    .component('lucide-home', Home)

window.Alpine = Alpine;

Alpine.start();
