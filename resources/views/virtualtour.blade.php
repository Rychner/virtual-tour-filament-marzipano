<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Virtual Tour</title>
    <style>
        html, body { margin:0; height:100%; overflow:hidden; }
        #pano { width: 100%; height: 100%; }
        .hotspot-icon {
            display: block;
            width: 32px;
            height: 32px;
            cursor: pointer;
        }

        .hotspot {
            position: relative;
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
            top: 20px;
            left: 60px;
            
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

        #roomMapContainer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 260px;
            background: rgba(0,0,0,0.6);
            color: white;
            border-radius: 12px;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        #roomMapHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            cursor: pointer;
        }

        #toggleRoomMap {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        #roomMapContent {
            padding: 12px;
        }

        .hidden {
            display: none;
        }

        .category-btn, .room-item, #backToCategory {
            width: 100%;
            margin: 6px 0;
            padding: 8px;
            background: #2563eb;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        .category-btn:hover, #backToCategory:hover {
            background: #1d4ed8;
        }

        .pulse-wrapper.pulse::after {
            content: "";
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            animation: pulse-ring 1.5s infinite;
            border: 2px solid rgba(0, 150, 255, 0.7);
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .hotspot.pulse {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(0, 150, 255, 0.7);
            }
            70% {
                transform: scale(1.2);
                box-shadow: 0 0 0 15px rgba(0, 150, 255, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(0, 150, 255, 0);
            }
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

    <div id="roomMapContainer">
        <div id="roomMapHeader">
            <span>Room Map</span>
            <button id="toggleRoomMap">▲</button>
        </div>

        <div id="roomMapContent" class="hidden">

            <!-- KATEGORI -->
            <div id="categoryList">
                <button class="category-btn" data-category="dosen">Ruang Dosen</button>
                <button class="category-btn" data-category="rapat">Ruang Rapat</button>
                <button class="category-btn" data-category="kelas">Ruang Kelas</button>
            </div>

            <!-- LIST RUANGAN -->
            <div id="roomsList" class="hidden">
                <button id="backToCategory">← Kembali</button>
                <div id="roomss"></div>
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
            const roomCategories = @json($rooms);

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

            function focusToHotspot(scene, hotspot) {
                const view = scene.view();

                view.setYaw(hotspot.yaw * Math.PI / 180);
                
                view.setPitch(hotspot.pitch * Math.PI / 180);
            }       

            function showPanorama(panorama, highlightHotspotSlug = null) {
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
                    el.dataset.label = h.label;
                    
                    el.innerHTML = `
                        <div class="pulse-wrapper">
                            <img class="hotspot-icon" src="/storage/${h.icon_path}">
                        </div>
                        <div class="hotspot-tooltip">${h.label ?? ''}</div>
                    `;

                    // 🎯 HIGHLIGHT HOTSPOT
                    if (highlightHotspotSlug && h.id === highlightHotspotSlug) {
                        setTimeout(() => {
                            el.querySelector(".pulse-wrapper")?.classList.add("pulse");
                            focusToHotspot(scene, h);
                        }, 300); // delay kecil biar scene siap
                    } 

                    el.onclick = () => {
                        if (h.target_panorama_id === panorama.id) return;
                        const target = panoramas.find(p => p.id === h.target_panorama_id);
                        if (target) showPanorama(target);
                    };

                    const hotspotObj = scene.hotspotContainer().createHotspot(el, {
                        yaw: h.yaw * Math.PI / 180,
                        pitch: h.pitch * Math.PI / 180
                    });                          
                });

                // Update info popup title + content
                document.getElementById("infoTitle").innerText = panorama.name;
                document.getElementById("infoContent").innerText = panorama.description || "Tidak ada informasi.";
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

            const toggleBtnRoom = document.getElementById("toggleRoomMap");
            const contentRoom = document.getElementById("roomMapContent");

            const categoryList = document.getElementById("categoryList");
            const roomList = document.getElementById("roomsList");
            const roomsContainer = document.getElementById("roomss");
            const backBtn = document.getElementById("backToCategory");

            // TOGGLE ROOM MAP
            toggleBtnRoom.onclick = () => {
                contentRoom.classList.toggle("hidden");
                toggleBtnRoom.innerText = contentRoom.classList.contains("hidden") ? "▲" : "▼";
            };

            document.querySelectorAll(".category-btn").forEach(btn => {
                btn.onclick = () => {
                    const category = btn.dataset.category;

                    categoryList.classList.add("hidden");
                    roomList.classList.remove("hidden");

                    roomsContainer.innerHTML = "";

                    if(!roomCategories[category]) return;

                    roomCategories[category].forEach(room => {
                        const el = document.createElement("button");
                        el.className = "room-item";
                        el.innerText = room.name;

                        el.onclick = () => {
                            const panorama = panoramas.find(
                                p => p.id === room.panorama_id
                            );
                            if (panorama) showPanorama(panorama, room.hotspot_id);
                        };

                        roomsContainer.appendChild(el);
                    });
                };
            });

            backBtn.onclick = () => {
                roomList.classList.add("hidden");
                categoryList.classList.remove("hidden");
            };

            // === EVENT INFO BUTTON ===
            document.getElementById("infoButton").onclick = () => {
                document.getElementById("infoPopup").style.display = "block";
            };

            // Close popup
            document.getElementById("infoPopupClose").onclick = () => {
                document.getElementById("infoPopup").style.display = "none";
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
