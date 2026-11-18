<?= $this->extend("layout/sablona"); ?>

<?= $this->section("titulek"); ?>
    <title>Jízdy</title>
<?= $this->endSection(); ?>

<?= $this->section("content"); ?>
<body>
  <h1 class="mt-1 mb-2">Jízdy</h1> <!-- Celé předělat, aby to bylo na odkaz nynější stránky (ve finále odkaz na stránku s odjezdovou tabulí z dané zastávky) -->
  <main>
    <section id="qr-code">
    </section>

    <section id="stats" class="card mb-4">
        <div class="card-body">
            <h2 class="h5 card-title">Počet odjezdů za zastávku</h2>
            <p class="text-muted mb-3">Aktuální týden <?= esc($weekStart) ?>–<?= esc($weekEnd) ?></p>
            <div id="weeklyDeparturesChart" style="width: 100%; height: 360px;" role="img" aria-label="Graf počtu odjezdů podle dnů týdne"></div>
        </div>
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












</body>
  <script type="module">
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

  <script>
    const weeklyDepartureCounts = <?= json_encode($departureCounts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

    if (typeof echarts === 'undefined') {
      console.error('ECharts nebyl načten.');
    } else {
      const chartElement = document.getElementById('weeklyDeparturesChart');
      const departuresChart = echarts.init(chartElement);

      departuresChart.setOption({
        title: {
          text: 'Počet odjezdů',
          left: 'center'
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: { type: 'shadow' },
          formatter: '{b}: {c} odjezdů'
        },
        grid: {
          left: '3%',
          right: '4%',
          bottom: '3%',
          containLabel: true
        },
        xAxis: {
          type: 'category',
          data: ['Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota', 'Neděle'],
          axisLabel: { interval: 0 }
        },
        yAxis: {
          type: 'value',
          minInterval: 1,
          name: 'Počet spojů'
        },
        series: [{
          name: 'Odjezdy',
          type: 'bar',
          data: weeklyDepartureCounts,
          barMaxWidth: 48,
          itemStyle: {
            borderRadius: [4, 4, 0, 0],
            color: '#36a2eb'
          },
          label: {
            show: true,
            position: 'top'
          }
        }]
      });

      window.addEventListener('resize', () => departuresChart.resize());
    }
  </script>

<?= $this->endSection(); ?>