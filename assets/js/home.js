const API_URL = "/api/root.php";

$(document).ready(
  () => {
    // Toggle action for nav bar on mobile mode
    $("#toggler").on("click", (e) => {
      $(e.currentTarget).toggleClass("change");
      $("#topnav").toggleClass("responsive")
    });

    // Close button for alert notification
    $("#closeAlert").on("click", (e) => {
      $(e.currentTarget).parent().css({ "opacity": 0 });
    });

    // Submit action on submit form
    $("#scrapeForm").on("submit", (e) => {
      e.preventDefault();
      $("#alert").removeClass("success").css({"opacity": 0});
      $("#statisticPanel").fadeOut();
      $(".scrapeBtn").attr("disabled", true);
      $("#loading").text("").addClass("loading");

      $.post(API_URL, {
        api: "SCRAPE_URL",
        url: url.value,
        element: element.value
      }, (response) => {
        setTimeout(() => {
          $(".scrapeBtn").attr("disabled", false);
          $("#loading").text("Check").removeClass("loading");
        }, 500);
        response = JSON.parse(response);

        if (response.status === 0) {
          if (response.data.msg === "success") { // Show response data
            $("#alert").addClass("success").css({"opacity": 1});
            $("#alertMessage").html(`URL ${response.data.scrapeData.domain}/${response.data.scrapeData.path} fetched on ${response.data.scrapeData.time}, took ${response.data.scrapeData.duration} msec.<br />Element '${response.data.scrapeData.element}' appeared ${response.data.scrapeData.count} times in page.`);

            $("#statisticPanel").fadeIn();
            $("#average_fetch_time").text(response.data.staData.averageTime + "(ms)");
            $("#urls_from_domain").text(response.data.staData.urlCount);
            $("#span_element_name1, #span_element_name2").text(response.data.scrapeData.element);
            $("#span_domain_name").text(response.data.scrapeData.domain);
            $("#elements_from_domain").text(response.data.staData.elementDomain);
            $("#elements_so_far").text(response.data.staData.elementCount);
          } else { // Show error message
            $("#alert").removeClass("success").css({"opacity": 1});
            $("#alertMessage").text(response.data.msg);
          }
        }
      })
    })

  }
)