jQuery(document).ready(function ($) {
  let currentFilter = "All";
  let currentSearch = "";

  function applyFilters() {
    $(".match-card").each(function () {
      const league = $(this).data("league");
      const status = $(this).data("status");
      const home = $(this).data("home");
      const away = $(this).data("away");

      const matchFilter =
        currentFilter === "All" ||
        league === currentFilter ||
        status === currentFilter;

      const matchSearch =
        home.includes(currentSearch) || away.includes(currentSearch);

      if (matchFilter && matchSearch) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }

  function loadScores() {
    $.ajax({
      url: wpLivescore.plugin_url + "data/data.json",
      method: "GET",
      dataType: "json",
      success: function (response) {
        const container = $("#wp-livescore-output");
        container.empty();

        if (Array.isArray(response) && response.length > 0) {
          response.forEach((match) => {
            const matchCard = `
              <div class="card match-card" 
                   data-league="${match.league}" 
                   data-status="${match.status}" 
                   data-home="${match.home_team.toLowerCase()}" 
                   data-away="${match.away_team.toLowerCase()}">
                <div class="card-body">
                  <h6 class="card-title text-muted mb-1">${match.league}</h6>
                  <div class="d-flex justify-content-between">
                    <span>${match.home_team}</span>
                    <strong>${match.score || match.time}</strong>
                    <span>${match.away_team}</span>
                  </div>
                  <div class="text-end text-muted small">${match.status}</div>
                </div>
              </div>`;
            container.append(matchCard);
          });

          applyFilters(); // Preserve filters and search
        } else {
          container.html('<p class="text-muted">No match data available.</p>');
        }
      },
      error: function (err) {
        console.error("Error loading JSON:", err);
        $("#wp-livescore-output").html(
          '<p class="text-danger">Failed to load match data.</p>'
        );
      },
    });
  }

  // Filtering
  $(document).on("click", ".league-link, .league-filter", function (e) {
    e.preventDefault();
    currentFilter = $(this).data("league");
    applyFilters();
  });

  // Search
  $("#team-search").on("keyup", function () {
    currentSearch = $(this).val().toLowerCase();
    applyFilters();
  });
  
  $("#wp-block-search__input-1").on("keyup", function () {
    currentSearch = $(this).val().toLowerCase();
    applyFilters();
  });

  // Initial load
  loadScores();

  // 🔁 Auto-refresh every X milliseconds
  setInterval(function () {
    loadScores();
  }, 30000); // default: 30s
});
