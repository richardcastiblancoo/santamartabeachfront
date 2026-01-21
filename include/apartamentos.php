<section class="py-20 bg-[#101c22]" id="apartamentos">
    <div class="px-6 md:px-20 mb-10 text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Apartamentos Destacados</h2>
        <p class="text-gray-400 text-sm">Nuestras mejores propiedades para una estancia inolvidable</p>
    </div>

    <div class="flex flex-wrap justify-center gap-6 px-6 md:px-20">
        <?php
        // Ajustar ruta de conexión dependiendo de dónde se incluya
        $ruta_conexion = 'auth/conexion_be.php';
        if (!file_exists($ruta_conexion)) {
            $ruta_conexion = '../auth/conexion_be.php';
            if (!file_exists($ruta_conexion)) {
                 $ruta_conexion = '../../auth/conexion_be.php';
            }
        }
        
        include_once $ruta_conexion;

        $sql = "SELECT a.*, COALESCE(AVG(r.calificacion), 0) as promedio_calificacion 
                FROM apartamentos a 
                LEFT JOIN resenas r ON a.id = r.apartamento_id 
                GROUP BY a.id 
                ORDER BY a.fecha_creacion DESC LIMIT 6";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <article class="max-w-[360px] w-full bg-[#1e2930]/40 backdrop-blur-md rounded-3xl overflow-hidden shadow-2xl group border border-white/10 transition-all duration-300 hover:border-blue-500/30">
                    
                    <div class="relative h-60 overflow-hidden">
                        <div class="absolute top-3 right-3 z-10 bg-[#101c22]/80 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold text-white flex items-center gap-1 border border-white/5">
                            <span class="material-symbols-outlined text-yellow-500 text-xs" style="font-variation-settings: 'FILL' 1;">star</span> <?php echo number_format($row['promedio_calificacion'], 1); ?>
                        </div>
                        
                        <?php
                        // Usar ruta absoluta desde la raíz del servidor para evitar problemas con includes
                        $ruta_web_img = '/assets/img/apartamentos/' . $row['imagen_principal'];
                        ?>

                        <div class="h-full w-full bg-cover bg-center group-hover:scale-105 transition-transform duration-500" 
                             style="background-image: url('<?php echo $ruta_web_img; ?>');">
                        </div>

                        <div class="absolute inset-0 bg-gradient-to-t from-[#101c22]/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
                            <button class="w-full bg-blue-600 text-white font-bold py-2 rounded-xl text-xs uppercase tracking-wider shadow-lg">
                                Reservar Ahora
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1"><?php echo $row['ubicacion']; ?></div>
                        <h3 class="text-xl font-bold text-white mb-2"><?php echo $row['titulo']; ?></h3>
                        <p class="text-gray-400 text-xs mb-6 leading-relaxed line-clamp-2">
                            <?php echo $row['descripcion']; ?>
                        </p>

                        <div class="grid grid-cols-3 gap-2 text-[10px] text-gray-400 mb-6">
                            <div class="flex flex-col items-center gap-1 p-2 bg-white/5 rounded-xl">
                                <span class="material-symbols-outlined text-blue-400 text-lg">bed</span>
                                <span><?php echo $row['habitaciones']; ?> Hab</span>
                            </div>
                            <div class="flex flex-col items-center gap-1 p-2 bg-white/5 rounded-xl">
                                <span class="material-symbols-outlined text-blue-400 text-lg">shower</span>
                                <span><?php echo $row['banos']; ?> Baños</span>
                            </div>
                            <div class="flex flex-col items-center gap-1 p-2 bg-white/5 rounded-xl">
                                <span class="material-symbols-outlined text-blue-400 text-lg">groups</span>
                                <span><?php echo $row['capacidad']; ?> Pers</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-5 border-t border-white/5">
                            <div>
                                <span class="text-xl font-black text-white">$<?php echo number_format($row['precio'], 0, ',', '.'); ?></span>
                                <span class="text-gray-400 text-[10px]">/noche</span>
                            </div>
                            <a href="/php/reserva-apartamento/apartamento.php?id=<?php echo $row['id']; ?>" 
                               class="bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-lg font-bold text-[11px] transition-all">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </article>
                <?php
            }
        } else {
            echo '<p class="text-gray-400 w-full text-center">No hay apartamentos disponibles por el momento.</p>';
        }
        ?>
    </div>
</section>
