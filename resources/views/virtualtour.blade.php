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
            width: 24px;
            height: 24px;
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

    <!-- Library Marzipano -->
    <script src="https://unpkg.com/marzipano@0.10.1/dist/marzipano.js"></script>
    <script>
        const panoramas = @json($panoramas); // data dari controller
        let currentPanorama = panoramas[0]; // mulai dari panorama pertama

        // Marzipano viewer
        const viewer = new Marzipano.Viewer(document.getElementById('pano'));

        function showPanorama(panorama) {
        const source = Marzipano.ImageUrlSource.fromString("/storage/" + panorama.image_path);
        const geometry = new Marzipano.EquirectGeometry([{ width: 4000 }]);
        const limiter = Marzipano.RectilinearView.limit.traditional(1024, 100*Math.PI/180);

        const view = new Marzipano.RectilinearView({
            yaw: panorama.initial_yaw * Math.PI/180,
            pitch: panorama.initial_pitch * Math.PI/180,
            fov: panorama.initial_fov * Math.PI/180
        }, limiter);

        const scene = viewer.createScene({ source, geometry, view });
        scene.switchTo();

        // hapus hotspot lama
        document.querySelectorAll('.hotspot').forEach(el => el.remove());

        // tampilkan hotspot
        panorama.hotspots.forEach(h => {
            const el = document.createElement("div");
            el.className = "hotspot";
            el.innerHTML = `<img class="hotspot-icon" src="/storage/${h.icon_path}">`;

            el.onclick = () => {
                const target = panoramas.find(p => p.id === h.target_panorama_id);
                if (target) showPanorama(target);
            };

            scene.hotspotContainer().createHotspot(el, {
                yaw: h.yaw * Math.PI / 180,
                pitch: h.pitch * Math.PI / 180
            });
        });

        // Update info popup title + content
        document.getElementById("infoTitle").innerText = panorama.name;
        document.getElementById("infoContent").innerText = panorama.description || "Tidak ada informasi.";      
        
    }

    // === EVENT INFO BUTTON ===
    document.getElementById("infoButton").onclick = () => {
            document.getElementById("infoPopup").style.display = "block";
        };

    // Close popup
    document.getElementById("infoPopupClose").onclick = () => {
        document.getElementById("infoPopup").style.display = "none";
    };

    showPanorama(currentPanorama);   

    </script>
</body>
</html>
