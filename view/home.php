<?php require "layout/header.php" ?>
  <div class="container">
    <div class="d-flex-centered">
      <div class="alert" id="alert">
        <span class="closebtn" id="closeAlert">&times;</span>
        <span id="alertMessage"></span>
      </div>
      <form id="scrapeForm">
        <label for="url">URL:</label>
        <input type="url" id="url" name="url" placeholder="Please input URL" required>

        <label for="element">Element:</label>
        <input type="text" id="element" name="element" placeholder="Please input element" pattern="[a-zA-Z0-9]+" required>

        <button type="submit" value="Check" class="scrapeBtn">
          <span id="loading">Check</span>
        </button>
      </form>
      <div class="statistic-panel" id="statisticPanel">
        <p>Average fetch time from domain during 24hours: </p>
        <p class="result" id="average_fetch_time"></p>
        <p>Urls fetched from domain: </p>
        <p class="result" id="urls_from_domain"></p>
        <p>Total &lt;<span id="span_element_name1">___</span>&gt; elements fetched from <span id="span_domain_name">___</span>:</p>
        <p class="result" id="elements_from_domain"></p>
        <p>Total &lt;<span id="span_element_name2">___</span>&gt; elements fetched so far:</p>
        <p class="result" id="elements_so_far"></p>
      </div>
    </div>
  </div>
  </main>
  <!-- script goes here -->
  <script src="<?php echo ASSETS; ?>/js/home.js"></script>
<?php require "layout/footer.php" ?>