let currentPage = 1;
let fixturesPerPage = 5; 
let currentFixtures = [];

document.addEventListener("DOMContentLoaded", function() {
    const apiHost = 'api-football-v1.p.rapidapi.com';
    const apiKey = 'd5f6cf4283mshafca4b5bdbea7c6p168bafjsn24b159c377d0';

    // Fetch live fixtures on page load
    fetchFixtures(apiHost, apiKey);

    // Add event listener for fetching fixtures by date
    document.getElementById('dateForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const date = document.getElementById('dateInput').value;
        fetchFixturesByDate(date, apiHost, apiKey);
    });

    // Add event listener to handle "Home" button click for page reload
    document.getElementById('homeButton').addEventListener('click', function() {
        window.location.reload();
    });
    document.getElementById('teamSearchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const teamName = document.getElementById('teamSearchInput').value.trim();
        if (teamName) {
            searchTeamAndFetchFixtures(teamName, apiHost, apiKey);
        }
    });
});

function searchTeamAndFetchFixtures(teamName, apiHost, apiKey) {
    
    const searchUrl = `https://${apiHost}/v3/teams?search=${encodeURIComponent(teamName)}`;
    fetch(searchUrl, {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': apiKey,
            'X-RapidAPI-Host': apiHost
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.response.length > 0) {
            const teamId = data.response[0].team.id; 
            fetchTeamFixtures(teamId, apiHost, apiKey);
        } else {
            document.getElementById('fixture-details').innerHTML = 'No team found with that name.';
        }
    })
    .catch(error => {
        console.error('Error searching for team:', error);
        document.getElementById('fixture-details').innerText = 'Failed to search for team: ' + error.message;
    });
}
function fetchTeamFixtures(teamId, apiHost, apiKey) {
    // Get today's date and the date from two weeks ago
    const today = new Date();
    const twoWeeksAgo = new Date();
    twoWeeksAgo.setDate(today.getDate() - 14); 

    // Format dates as YYYY-MM-DD
    const fromDate = twoWeeksAgo.toISOString().split('T')[0];
    const toDate = today.toISOString().split('T')[0];

    // Construct the URL to get fixtures from two weeks ago to today
    const fixturesUrl = `https://${apiHost}/v3/fixtures?team=${teamId}&season=2023&from=${fromDate}&to=${toDate}`;

    // Fetch the fixtures from the API
    fetch(fixturesUrl, {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': apiKey,
            'X-RapidAPI-Host': apiHost
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.response || data.response.length === 0) {
            document.getElementById('fixture-details').innerHTML = 'No fixtures found for this team in the last two weeks.';
            return;
        }
        currentFixtures = data.response;
        currentPage = 1;
        displayFixtures(currentPage);
    })
    .catch(error => {
        console.error('Fetch error:', error);
        document.getElementById('fixture-details').innerText = `Failed to load fixtures: ${error.message}`;
    });
}


function fetchFixturesByDate(date, apiHost, apiKey) {
    const url = `https://${apiHost}/v3/fixtures?date=${date}`;
    fetch(url, {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': apiKey,
            'X-RapidAPI-Host': apiHost
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.response || data.response.length === 0) {
            document.getElementById('fixture-details').innerHTML = 'No fixtures found for this date.';
            return;
        }
        currentFixtures = data.response;
        currentPage = 1; 
        displayFixtures(currentPage);
    })
    .catch(error => {
        console.error('Fetch error:', error);
        document.getElementById('fixture-details').innerText = `Failed to load data: ${error.message}`;
    });
}

function fetchFixtures(apiHost, apiKey) {
    const url = `https://${apiHost}/v3/fixtures?live=all`; // API link
    fetch(url, {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': apiKey,
            'X-RapidAPI-Host': apiHost
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.response || data.response.length === 0) {
            document.getElementById('fixture-details').innerHTML = 'No live fixtures found.';
            return;
        }
        currentFixtures = data.response;
        displayFixtures(currentPage);
    })
    .catch(error => {
        console.error('Fetch error:', error);
        document.getElementById('fixture-details').innerText = `Failed to load data: ${error.message}`;
    });
}

function displayFixtures(page) {
    const start = (page - 1) * fixturesPerPage;
    const end = start + fixturesPerPage;
    const paginatedFixtures = currentFixtures.slice(start, end);
    
    const fixtureElement = document.getElementById('fixture-details');
    fixtureElement.innerHTML = ''; 
    paginatedFixtures.forEach(fixture => {
        const details = `
            <div class="fixture">
                <h2>${fixture.league.name} - ${new Date(fixture.fixture.date).toLocaleString()}</h2>
                <p>
                    <img src="${fixture.teams.home.logo}" alt="${fixture.teams.home.name} Logo" style="height:50px; width:auto;"> 
                    <strong>${fixture.teams.home.name}</strong> (${fixture.goals.home}) vs <strong>${fixture.teams.away.name}</strong> (${fixture.goals.away})
                    <img src="${fixture.teams.away.logo}" alt="${fixture.teams.away.name} Logo" style="height:50px; width:auto;"> 
                    
                </p>
                <p>Status: ${fixture.fixture.status.long} (${fixture.fixture.status.short}), Elapsed Time: ${fixture.fixture.status.elapsed} minutes</p>
                <p>Venue: ${fixture.fixture.venue.name}, ${fixture.fixture.venue.city}</p>
            </div>
        `;
        fixtureElement.innerHTML += details;
    });

    // Update page information and button visibility
    document.getElementById('page-info').textContent = `Page ${page} of ${Math.ceil(currentFixtures.length / fixturesPerPage)}`;
    document.getElementById('back-to-top').style.display = 'block';
}


function nextPage() {
    if ((currentPage * fixturesPerPage) < currentFixtures.length) {
        currentPage++;
        displayFixtures(currentPage);
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        displayFixtures(currentPage);
    }
}

function scrollToTop() {
    window.scrollTo({top: 0, behavior: 'smooth'});
}
window.onscroll = function() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById('back-to-top').style.display = "block";
    } else {
        document.getElementById('back-to-top').style.display = "none";
    }
};


document.getElementById('chatButton').addEventListener('click', function() {
         document.getElementById('chat-container').classList.toggle('show');
});
