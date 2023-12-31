<?php require "layout/header.php" ?>
<div class="container">
  <div class="d-flex-centered">
    <div class="alert">
      <span class="closebtn" id="closeAlert">&times;</span>
    </div>
    <form class="big-form">
      <label for="domain"> Select Domain(120) </label>
      <select id="domain" name="domain">
        <option>Google.com</option>
      </select>
      <p>Average fetch time from domain during 24hours</p>
      <p class="result" id="average_fetch_time">___</p>
      <p>Urls fetched from domain</p>
      <p class="result" id="urls_from_domain">___</p>
      <hr class="separator" />
      <label for="domain"> Select Element(30) </label>
      <select name="element" id="element">
        <option>div</option>
        <option>label</option>
      </select>
      <p>Total &lt;<span id="span_element_name1">___</span>&gt; elements fetched from <span id="span_domain_name">___</span></p>
      <p class="result" id="elements_from_domain">___</p>
      <p>Total &lt;<span id="span_element_name2">___</span>&gt; elements fetched so far</p>
      <p class="result" id="elements_so_far">___</p>
    </form>
  </div>
</div>
</main>
<!-- script goes here -->
<script src="<?php echo ASSETS; ?>/js/statistic.js"></script>
<?php require "layout/footer.php" ?>