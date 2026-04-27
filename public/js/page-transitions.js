/**
 * Page Transitions System
 * Masjid Al-Hasanah Professional Transitions
 */

class PageTransitions {
    constructor() {
        this.loader = null;
        this.isTransitioning = false;
        this.init();
    }

    init() {
        this.createLoader();
        this.setupEventListeners();
        this.addInitialAnimations();
    }

    createLoader() {
        // Create loader element if not exists
        if (!document.querySelector('.page-loader')) {
            this.loader = document.createElement('div');
            this.loader.className = 'page-loader';
            this.loader.innerHTML = `
                <div class="mosque-loader">
                    <div class="loading-dots">
                        <div class="loading-dot"></div>
                        <div class="loading-dot"></div>
                        <div class="loading-dot"></div>
                    </div>
                </div>
            `;
            document.body.appendChild(this.loader);
        } else {
            this.loader = document.querySelector('.page-loader');
        }
    }

    setupEventListeners() {
        // Handle all internal links
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (link && this.shouldTransition(link)) {
                e.preventDefault();
                this.transitionToPage(link.href);
            }
        });

        // Handle form submissions
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (this.shouldTransitionForm(form)) {
                this.showLoader();
            }
        });

        // Handle browser back/forward
        window.addEventListener('popstate', () => {
            this.showLoader();
            setTimeout(() => {
                this.hideLoader();
                this.animatePageEntry();
            }, 300);
        });

        // Handle page load
        window.addEventListener('load', () => {
            this.hideLoader();
            this.animatePageEntry();
        });
    }

    shouldTransition(link) {
        const href = link.href;
        const currentUrl = window.location.href;
        
        // Don't transition for external links, anchors, or same page
        if (!href || href.includes('#') || href === currentUrl) {
            return false;
        }

        // Only transition for internal links
        return href.includes(window.location.hostname);
    }

    shouldTransitionForm(form) {
        // Don't show loader for search forms or small forms
        return !form.classList.contains('no-transition') && 
               !form.querySelector('input[type="search"]');
    }

    transitionToPage(url) {
        if (this.isTransitioning) return;
        
        this.isTransitioning = true;
        this.showLoader();

        // Simulate page load and redirect
        setTimeout(() => {
            window.location.href = url;
        }, 500);
    }

    showLoader() {
        if (this.loader) {
            this.loader.classList.add('active');
        }
    }

    hideLoader() {
        if (this.loader) {
            this.loader.classList.remove('active');
        }
        this.isTransitioning = false;
    }

    addInitialAnimations() {
        // Add animations to page elements
        this.animatePageEntry();
    }

    animatePageEntry() {
        const pageType = this.getPageType();
        const mainContent = document.querySelector('main, .main-content, .container');
        
        if (mainContent) {
            // Remove existing animations
            mainContent.classList.remove('fade-in', 'fade-in-up', 'fade-in-down', 'fade-in-left', 'fade-in-right');
            
            // Add appropriate animation based on page type
            switch(pageType) {
                case 'login':
                    mainContent.classList.add('login-page-transition');
                    break;
                case 'dashboard':
                    mainContent.classList.add('dashboard-page-transition');
                    break;
                case 'kitab':
                    mainContent.classList.add('kitab-page-transition');
                    break;
                default:
                    mainContent.classList.add('fade-in-up');
            }

            // Animate child elements with stagger
            this.animateChildren(mainContent);
        }
    }

    animateChildren(container) {
        const children = container.querySelectorAll('h1, h2, h3, .card, .btn, .nav-item, .form-group');
        children.forEach((child, index) => {
            child.style.opacity = '0';
            child.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s forwards`;
        });
    }

    getPageType() {
        const path = window.location.pathname;
        
        if (path.includes('/login')) return 'login';
        if (path.includes('/dashboard')) return 'dashboard';
        if (path.includes('/kitab')) return 'kitab';
        if (path.includes('/admin')) return 'dashboard';
        
        return 'default';
    }

    // Public methods for manual control
    manualTransition(callback) {
        this.showLoader();
        setTimeout(() => {
            if (callback) callback();
            this.hideLoader();
            this.animatePageEntry();
        }, 500);
    }

    // Add hover effects to interactive elements
    addHoverEffects() {
        // Links
        document.querySelectorAll('a:not(.no-transition)').forEach(link => {
            link.classList.add('transition-link');
        });

        // Buttons
        document.querySelectorAll('button:not(.no-transition)').forEach(btn => {
            btn.classList.add('btn-transition');
        });

        // Cards
        document.querySelectorAll('.card, .stats-card').forEach(card => {
            card.classList.add('card-transition');
        });

        // Form inputs
        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.classList.add('form-input-transition');
        });

        // Navigation items
        document.querySelectorAll('.nav-item, .menu-item').forEach(item => {
            item.classList.add('nav-item-transition');
        });
    }

    // Smooth scroll for anchor links
    setupSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // Initialize all effects
    init() {
        this.createLoader();
        this.setupEventListeners();
        this.addHoverEffects();
        this.setupSmoothScroll();
        
        // Add initial animations after page load
        setTimeout(() => {
            this.animatePageEntry();
        }, 100);
    }
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.pageTransitions = new PageTransitions();
});

// Export for manual usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PageTransitions;
}
