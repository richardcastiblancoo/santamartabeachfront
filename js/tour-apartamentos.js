document.addEventListener('DOMContentLoaded', function() {
    const driver = window.driver.js.driver;

    const driverObj = driver({
        showProgress: true,
        animate: true,
        prevBtnText: "Anterior",
        nextBtnText: "Siguiente",
        doneBtnText: "Finalizar",
        steps: [
            { 
                element: '#sidebar-menu', 
                popover: { 
                    title: 'Menú de Navegación', 
                    description: 'Desde aquí puedes acceder a las diferentes secciones del sistema administrativo.' 
                } 
            },
            { 
                element: '#search-bar-container', 
                popover: { 
                    title: 'Búsqueda Rápida', 
                    description: 'Encuentra propiedades específicas buscando por nombre o ubicación.' 
                } 
            },
            { 
                element: '#add-apartment-btn', 
                popover: { 
                    title: 'Nuevo Apartamento', 
                    description: 'Haz clic aquí para registrar una nueva propiedad en el inventario.' 
                } 
            },
            { 
                element: '#apartments-list', 
                popover: { 
                    title: 'Listado de Propiedades', 
                    description: 'Aquí se visualizan todos los apartamentos registrados ordenados por fecha de creación.' 
                } 
            },
            { 
                element: '.apartment-card:first-child', 
                popover: { 
                    title: 'Tarjeta de Propiedad', 
                    description: 'Cada tarjeta muestra la información clave: imagen, precio, ubicación y estado.' 
                } 
            },
            { 
                element: '.apartment-card:first-child .btn-view', 
                popover: { 
                    title: 'Vista Previa', 
                    description: 'Observa cómo verán los clientes esta propiedad en el sitio web.' 
                } 
            },
            { 
                element: '.apartment-card:first-child .btn-edit', 
                popover: { 
                    title: 'Editar Propiedad', 
                    description: 'Modifica la información, imágenes, precios y características del apartamento.' 
                } 
            },
            { 
                element: '.apartment-card:first-child .btn-delete', 
                popover: { 
                    title: 'Eliminar Propiedad', 
                    description: 'Elimina permanentemente el apartamento del sistema. ¡Ten cuidado!' 
                } 
            }
        ]
    });

    const startBtn = document.getElementById('start-tour-btn');
    if (startBtn) {
        startBtn.addEventListener('click', function() {
            driverObj.drive();
        });
    }
});
