<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Virtual Tour</title>
    <style>
        html, body { margin:0; height:100%; overflow:hidden; }
        #pano { width: 100%; height: 100%; }
        .hotspot-icon {
            position: absolute;
            width: 32px;
            height: 32px;
            cursor: pointer;
        }
        /* === Info Button (STATIC) === */
        #infoButton {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 9999;
            background: none;
            border: none;
            cursor: pointer;
        }
        #infoButton img {
            width: 24px;
            height: 24px;
        }

        /* === Modern Popup === */
        #infoPopup {
            position: fixed;
            top: 13%;
            left: 13%;
            transform: translate(-50%, -50%);
            width: 180px;
            max-width: 90%;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            padding: 20px;
            z-index: 99999;
            display: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.25);
            animation: fadeIn .25s ease;
            font-family: Arial, sans-serif;
        }
        @keyframes fadeIn {
            from { opacity:0; transform: translate(-50%, -48%); }
            to { opacity:1; transform: translate(-50%, -50%); }
        }        
        #infoTitle {
            font-weight: bold;
            color: white;            
        }
        #infoContent {
            font-weight: 500;
            color: white;            
        }
        #infoPopupClose {
            background: rgba(255, 255, 255, 0);
            font-weight: bold;
            color: red;
            border: none;
            padding: 4px 7px;
            border-radius: 8px;
            cursor: pointer;
            float: right;            
        }
        /* Tooltip */
        .hotspot-tooltip {
            position: absolute;
            bottom: 130%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.75);
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .hotspot:hover .hotspot-tooltip {
            opacity: 1;
            transform: translateX(-50%) translateY(-4px);
        }
        
        #floorMapContainer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 260px;
            background: rgba(0,0,0,0.6);
            color: white;
            border-radius: 12px;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        #floorMapHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            cursor: pointer;
        }

        #toggleFloorMap {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        #floorMapContent {
            padding: 12px;
        }

        .hidden {
            display: none;
        }

        .floor-btn, #backToFloor {
            width: 100%;
            margin: 6px 0;
            padding: 8px;
            background: #2563eb;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        .floor-btn:hover, #backToFloor:hover {
            background: #1d4ed8;
        }
    </style>    
</head>
<body>
    <div id="pano"></div>

    <!-- === INFO BUTTON (POJOK KIRI ATAS) === -->
    <button id="infoButton">
        <img src="{{ asset('assets/info.png') }}" alt="Info">
    </button>

    <!-- === POPUP INFO === -->
    <div id="infoPopup">
        <button id="infoPopupClose">x</button>
        <p id="infoTitle"></p>
        <p id="infoContent"></p>
    </div>

    <div id="floorMapContainer">
        <div id="floorMapHeader">
            <span>Floor Map</span>
            <button id="toggleFloorMap">▲</button>
        </div>
    
        <div id="floorMapContent" class="hidden">
            <!-- LIST LANTAI -->
            <div id="floorList">
                <button class="floor-btn" data-floor="1">Lantai 1</button>
                <button class="floor-btn" data-floor="2">Lantai 2</button>
                <button class="floor-btn" data-floor="3">Lantai 3</button>
                <button class="floor-btn" data-floor="4">Lantai 4</button>
                <button class="floor-btn" data-floor="5">Lantai 5</button>
            </div>
    
            <!-- LIST RUANGAN -->
            <div id="roomList" class="hidden">
                <button id="backToFloor">← Kembali</button>
                <div id="rooms"></div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const toggleBtn = document.getElementById("toggleFloorMap");
            const content = document.getElementById("floorMapContent");

            const floorList = document.getElementById("floorList");
            const roomList = document.getElementById("roomList");
            const roomsContainer = document.getElementById("rooms");
            const backBtn = document.getElementById("backToFloor");

            // DATA RUANGAN
            const floorRooms = {
                1: ["Lobby", "Ruang 120", "Tata Usaha", "Ruang Pimpinan"],
                2: ["Kamar Tidur 1", "Kamar Tidur 2"],
                3: ["Ruang Kerja"],
                4: ["Gudang"],
                5: ["Atap"]
            };

            // === FUNCTION TAMPILKAN RUANGAN ===
            window.showRoomsByFloor = function (floor) {
                if (!floorRooms[floor]) return;

                floorList.classList.add("hidden");
                roomList.classList.remove("hidden");

                roomsContainer.innerHTML = "";
                floorRooms[floor].forEach(room => {
                    const el = document.createElement("div");
                    el.innerText = "• " + room;
                    el.style.margin = "6px 0";
                    roomsContainer.appendChild(el);
                });
            };

            // TOGGLE FLOOR MAP
            toggleBtn.onclick = () => {
                content.classList.toggle("hidden");
                toggleBtn.innerText = content.classList.contains("hidden") ? "▲" : "▼";
            };

            // KLIK BUTTON LANTAI
            document.querySelectorAll(".floor-btn").forEach(btn => {
                btn.onclick = () => {
                    const floor = btn.dataset.floor;
                    showRoomsByFloor(floor);
                };
            });

            // KEMBALI KE LIST LANTAI
            backBtn.onclick = () => {
                roomList.classList.add("hidden");
                floorList.classList.remove("hidden");
            };

        });
    </script>


    <!-- Library Marzipano -->
    <script src="https://unpkg.com/marzipano@0.10.1/dist/marzipano.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            /* ===========================
            DATA PANORAMA DARI CONTROLLER
            =========================== */
            const panoramas = @json($panoramas);

            /* ===========================
            MAPPING LANTAI → PANORAMA
            (UBAH SESUAI DATA KAMU)
            =========================== */
            const floorPanoramaMap = {
                1: "lobby",
                2: "lantai-2",
                3: "ruang-kerja",
                4: "gudang",
                5: "atap"
            };

            /* ===========================
            MARZIPANO SETUP
            =========================== */
            const viewer = new Marzipano.Viewer(document.getElementById('pano'));
            let currentScene = null;

            function showPanorama(panorama) {
                if (!panorama) return;

                const source = Marzipano.ImageUrlSource.fromString(
                    "/storage/" + panorama.image_path
                );

                const geometry = new Marzipano.EquirectGeometry([{ width: 4000 }]);

                const limiter = Marzipano.RectilinearView.limit.traditional(
                    1024,
                    100 * Math.PI / 180
                );

                const view = new Marzipano.RectilinearView({
                    yaw: panorama.initial_yaw * Math.PI / 180,
                    pitch: panorama.initial_pitch * Math.PI / 180,
                    fov: panorama.initial_fov * Math.PI / 180
                }, limiter);

                const scene = viewer.createScene({
                    source,
                    geometry,
                    view
                });

                scene.switchTo();
                currentScene = scene;

                /* === HOTSPOT === */
                panorama.hotspots.forEach(h => {
                    const el = document.createElement("div");
                    el.className = "hotspot";
                    el.innerHTML = `
                        <img class="hotspot-icon" src="/storage/${h.icon_path}">
                        <div class="hotspot-tooltip">${h.label ?? ''}</div>
                    `;

                    el.onclick = () => {
                        if (h.target_panorama_id === panorama.id) return;
                        const target = panoramas.find(p => p.id === h.target_panorama_id);
                        if (target) showPanorama(target);
                    };

                    scene.hotspotContainer().createHotspot(el, {
                        yaw: h.yaw * Math.PI / 180,
                        pitch: h.pitch * Math.PI / 180
                    });
                });
            }

            /* ===========================
            FLOOR MAP EVENT
            =========================== */
            document.querySelectorAll(".floor-btn").forEach(btn => {
                btn.onclick = () => {
                    const floor = btn.dataset.floor;
                    const slug = floorPanoramaMap[floor];

                    const panorama = panoramas.find(p => p.slug === slug);
                    if (panorama) {
                        showPanorama(panorama);
                    } else {
                        alert("Panorama lantai belum terdaftar");
                    }

                    // 2. tampilkan list ruangan
                    if (window.showRoomsByFloor) {
                        window.showRoomsByFloor(floor);
                    }
                };
            });

            /* ===========================
            TOGGLE FLOOR MAP
            =========================== */
            const toggleBtn = document.getElementById("toggleFloorMap");
            const content = document.getElementById("floorMapContent");

            toggleBtn.onclick = () => {
                content.classList.toggle("hidden");
                toggleBtn.innerText = content.classList.contains("hidden") ? "▲" : "▼";
            };

            /* ===========================
            LOAD PERTAMA
            =========================== */
            showPanorama(panoramas[0]);
        });
    </script>
    

</body>
</html>


    
</body>
</html>
