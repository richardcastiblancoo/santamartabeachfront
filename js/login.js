 const translations = {
            es: {
                "hero-title": "Bienvenido al paraíso",
                "hero-desc": "Gestiona tus reservas, planifica tus vacaciones o administra tus propiedades frente al mar en Santa Marta de forma segura.",
                "social-proof": "+1k Usuarios confían en nosotros",
                "form-title": "Acceso a la plataforma",
                "form-subtitle": "Ingresa tus datos para continuar explorando.",
                "tab-login": "Iniciar Sesión",
                "tab-register": "Registrarse",
                "label-user": "Usuario",
                "label-pass": "Contraseña",
                "forgot-pass": "¿Olvidaste tu contraseña?",
                "btn-enter": "Entrar",
                "no-account": "¿No tienes una cuenta?",
                "link-register": "Regístrate aquí"
            },
            en: {
                "hero-title": "Welcome to Paradise",
                "hero-desc": "Manage your reservations, plan your vacations, or manage your beachfront properties in Santa Marta securely.",
                "social-proof": "+100 Users trust us",
                "form-title": "Platform Access",
                "form-subtitle": "Enter your details to continue exploring.",
                "tab-login": "Login",
                "tab-register": "Register",
                "label-user": "Username",
                "label-pass": "Password",
                "forgot-pass": "Forgot password?",
                "btn-enter": "Sign In",
                "no-account": "Don't have an account?",
                "link-register": "Register here"
            }
        };

        function changeLanguage(lang) {
            document.querySelectorAll('[data-key]').forEach(el => {
                const key = el.getAttribute('data-key');
                if (translations[lang][key]) el.innerText = translations[lang][key];
            });

            // Actualizar botones de idioma desktop
            const btnEs = document.getElementById('btn-es');
            const btnEn = document.getElementById('btn-en');

            if (lang === 'es') {
                btnEs.className = 'flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all bg-primary text-white';
                btnEn.className = 'flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all text-gray-500 hover:bg-white/10';
            } else {
                btnEn.className = 'flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all bg-primary text-white';
                btnEs.className = 'flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-lg transition-all text-gray-500 hover:bg-white/10';
            }

            // Cerrar menú si está en móvil
            if (!document.getElementById('mobileMenu').classList.contains('hidden')) toggleMenu();
        }

        // Lógica menú móvil
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('menuIcon');
            const isOpen = !menu.classList.contains('hidden');

            if (isOpen) {
                menu.classList.add('hidden');
                icon.textContent = 'menu';
                document.body.style.overflow = '';
            } else {
                menu.classList.remove('hidden');
                icon.textContent = 'close';
                document.body.style.overflow = 'hidden';
            }
        }

        document.getElementById('menuBtn').addEventListener('click', toggleMenu);