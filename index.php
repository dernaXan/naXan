<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>naXan</title>
<link rel="icon" href="E65170CF-2C2A-4301-9911-A7C1D40005E0.png" type="image/png" />
<style>
  body {
    background: #111;
    color: #ddd;
    font-family: Arial, sans-serif;
    margin: 20px;
    text-align: center;
  }

  h1 {
    margin-top: 0;
    margin-bottom: 10px;
  }

  #profile-pic {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 20px auto;
    display: block;
    box-shadow: 0 0 8px #e63946;
  }

  .video {
    background: #222;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 0 8px #000;
    cursor: pointer;
    overflow: hidden;
  }

  .video img {
    width: 100%;
    display: block;
    object-fit: cover;
    height: 120px;
    border-radius: 8px 8px 0 0;
  }

  .video p {
    margin: 8px 10px;
    font-size: 14px;
    color: #ddd;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  #show-more-btn {
    display: block;
    margin: 15px auto;
    padding: 10px 20px;
    background: #e63946;
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  #show-more-btn:hover {
    background: #d62828;
  }
  .navbar {
      background: #222;
      padding: 10px 20px;
      box-shadow: 0 2px 4px #000;
      position: relative;
      text-align: right;
    }

    .menu-toggle {
      font-size: 24px;
      color: #e63946;
      cursor: pointer;
      user-select: none;
    }

    .menu {
      list-style: none;
      padding: 10px 0 0;
      margin: 0;
      display: none;
      position: absolute;
      right: 20px;
      background: #111;
      border-radius: 6px;
      box-shadow: 0 4px 10px #000;
      z-index: 999;
    }

    .menu li {
      padding: 10px 20px;
    }

    .menu li a {
      color: #e63946;
      text-decoration: none;
      font-weight: bold;
      display: block;
    }

    .menu li a:hover {
      color: #fff;
      background: #e63946;
      border-radius: 4px;
    }

    .gallery.limited {
      max-height: calc(3 * 135px + 40px);
      position: relative;
    }

    .gallery.limited::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 40px;
      background: linear-gradient(transparent, #111);
      pointer-events: none;
    }

    #gallery-container {
      max-width: 600px;
      margin: 0 auto;
      position: relative;
      text-align: left;
    }

    .gallery {
      overflow: hidden;
      position: relative;
      transition: max-height 0.5s ease;
    }
  </style>

  <?php
    ob_start(); // Output zwischenspeichern
    echo '<script>document.addEventListener("DOMContentLoaded",function(){';
    echo 'const nav=`<div class="menu-toggle" onclick="toggleMenu()">☰</div><ul class="menu" id="menu">';

    foreach (scandir(__DIR__) as $dir) {
      if ($dir === '.' || $dir === '..' || $dir === 'util') continue;
      if (is_dir($dir) && (file_exists("$dir/index.html") || file_exists("$dir/index.php"))) {
        $label = ucfirst($dir);
        $path = htmlspecialchars($dir);
        echo "<li><a href='/$path/'>$label</a></li>";
      }
    }

    echo '</ul>`;document.querySelector("nav").innerHTML=nav;';
    echo '});';
    echo 'function toggleMenu(){const m=document.getElementById("menu");m.style.display=m.style.display==="block"?"none":"block";}';
    echo '</script>';
    ob_end_flush();
  ?>
</head>
<body>
<nav style="background: #222; padding: 10px 0; box-shadow: 0 2px 4px #000;">
  <ul style="list-style: none; display: flex; justify-content: center; margin: 0; padding: 0;">
    <li style="margin: 0 15px;">
      <a href="discord/" style="color: #e63946; text-decoration: none; font-weight: bold; font-size: 16px;">Discord</a>
    </li>
  </ul>
</nav>
  
<h1>naXan Videos</h1>
<img src="E65170CF-2C2A-4301-9911-A7C1D40005E0.png" alt="naXan Profilbild" id="profile-pic" />

<nav class="navbar"></nav>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1TZHYNSXDP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-1TZHYNSXDP');
</script>
<script>
const channelId = "UCxzx7sdLPG9XzxC-supGbiw";
const rssFeedUrl = `https://www.youtube.com/feeds/videos.xml?channel_id=${channelId}`;
const rss2jsonUrl = `https://api.rss2json.com/v1/api.json?rss_url=${encodeURIComponent(rssFeedUrl)}`;

const gallery = document.getElementById("video-gallery");
const showMoreBtn = document.getElementById("show-more-btn");

let videos = [];
let visibleCount = 4;
const showSteps = [4, 8, 13];

function renderGallery() {
  gallery.innerHTML = "";
  const maxToShow = visibleCount > videos.length ? videos.length : visibleCount;

  for (let i = 0; i < maxToShow; i++) {
    const v = videos[i];
    const videoDiv = document.createElement("div");
    videoDiv.className = "video";

    const a = document.createElement("a");
    a.href = v.url;
    a.target = "_blank";
    a.rel = "noopener noreferrer";

    const img = document.createElement("img");
    img.src = v.thumb;
    img.alt = v.title;

    a.appendChild(img);

    const p = document.createElement("p");
    p.textContent = v.title;

    videoDiv.appendChild(a);
    videoDiv.appendChild(p);

    gallery.appendChild(videoDiv);
  }

  if (visibleCount < videos.length) {
    gallery.classList.add("limited");
    showMoreBtn.style.display = "block";
  } else {
    gallery.classList.remove("limited");
    showMoreBtn.style.display = "none";
  }
}

showMoreBtn.addEventListener("click", () => {
  const nextIndex = showSteps.findIndex(x => x > visibleCount);
  if (nextIndex !== -1) {
    visibleCount = showSteps[nextIndex];
    renderGallery();
  } else {
    visibleCount = videos.length;
    renderGallery();
    showMoreBtn.style.display = "none";
  }
});

fetch(rss2jsonUrl)
  .then(res => res.json())
  .then(data => {
    if(data.status !== 'ok') throw new Error('RSS Fehler');
    videos = data.items.map(item => ({
      title: item.title,
      url: item.link,
      thumb: item.thumbnail
    }));
    renderGallery();
  })
  .catch(() => {
    gallery.innerHTML = "<p>Fehler beim Laden der Videos.</p>";
  });
</script>

</body>
</html>
