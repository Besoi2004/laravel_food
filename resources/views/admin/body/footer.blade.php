<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top">
    <div class="text-center text-md-left">
        <p class="mb-0 text-muted">
            <script>document.write(new Date().getFullYear())</script> © 
            <a href="/" class="text-blue hover:text-blue-600 transition-colors">
                Food Admin Dashboard
            </a>
        </p>
    </div>
    <div class="text-center text-md-right mt-2 mt-md-0">
        <p class="mb-0 text-muted">
            Crafted with 
            <i class="feather icon-heart text-danger mx-1"></i> 
            by 
            <a href="#" class="text-blue hover:text-blue-600 transition-colors">
                Your Company
            </a>
        </p>
    </div>
</footer>

<style>
.footer {
    
}

.footer:hover {
    box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
}

.text-blue {
    color: #4361ee;
    text-decoration: none;
}

.text-blue:hover {
    color: #2441e7;
}

.feather.icon-heart {
    animation: heartBeat 1.5s ease infinite;
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    14% { transform: scale(1.3); }
    28% { transform: scale(1); }
    42% { transform: scale(1.3); }
    70% { transform: scale(1); }
}

@media (max-width: 768px) {
    .footer {
        text-align: center;
        padding: 1rem;
    }
}
</style>