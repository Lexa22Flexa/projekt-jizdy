<?= $this->extend("layout/sablona"); ?>

<?= $this->section("titulek"); ?>
    <title>Jízdy</title>
<?= $this->endSection(); ?>

<?= $this->section("content"); ?>

<h1 class="mt-1 mb-2">Jízdy</h1> <!-- Celé předělat, aby to bylo na odkaz nynější stránky (ve finále odkaz na stránku s odjezdovou tabulí z dané zastávky) -->
  <main>
    <section>
    </section>
    <section id="qr-code">
    </section>
    <section id="stats">
    </section>
    <section id="tools">
        <div style="display: none"> <!-- Spíš předělat -->
          <label>Text: <input id="text" type="text" value='<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>'></label> <!-- Teoreticky je špatně(?) -->
          <label>Radius: <input id="radius" type="range" value="0" step="0.025" min="0" max="0.5"></label>
          <label>Error correction:
          <select id="ecLevel">
            <option value="L" label="Low, 7%">
            <option value="M" label="Medium, 15%">
            <option value="Q" label="Quarter, 25%">
            <option value="H" label="High, 30%" selected>
          </select></label>
          <label>Color: <input id="fill" type="color" value="#000"></label>
          <label>Background: <input id="background" type="color"><input id="transparent" type="checkbox" checked> transparent</label>
          <label>Size: <input id="size" type="range" value="250" step="10" min="20" max="1000"></label>
        </div>
    </section>
  </main>
  <script type="module">
    import QrCreator from 'https://cdn.jsdelivr.net/npm/qr-creator/dist/qr-creator.es6.min.js'; //předělat na tu stáhnutou
    let availableSettings = ['text', 'radius', 'ecLevel', 'fill', 'background', 'size'];

    function readSettings() {
      let settings = {}, el;
      for (let setting of availableSettings) {
        settings[setting] = document.querySelector('#'+setting).value;
      }
      if (document.querySelector('#transparent').checked) {
        settings.background = null;
      }
      return settings;
    }

    function renderQrCode() {
      let time = new Date(),
          container = document.querySelector('#qr-code'),
          settings = readSettings();
      container.innerHTML = '';
      QrCreator.render(settings, container);
      document.querySelector('#json').innerText = JSON.stringify(settings, null, 2);
    }

    for (let input of document.querySelectorAll('input, select')) {
      input.addEventListener('change', renderQrCode);
    }
    renderQrCode();

  </script>

<?= $this->endSection(); ?>