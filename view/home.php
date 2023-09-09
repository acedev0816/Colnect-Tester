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
        <input type="text" id="element" name="element" placeholder="Please input element" required>

        <button type="submit" value="Check" class="scrapeBtn">
          <span id="loading">Check</span>
        </button>
      </form>
    </div>
  </div>
  </main>
  <!-- script goes here -->
  <script src="<?php echo ASSETS; ?>/js/home.js"></script>
<?php require "layout/footer.php" ?>