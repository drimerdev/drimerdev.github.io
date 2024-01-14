function search() {
    const query = document.getElementById('query').value;

    // GitHub repository details
    const owner = 'drimerdev';
    const repo = 'msearchdata';
    const branch = 'main';

    // Fetch data from GitHub repository
    fetch(`https://api.github.com/repos/drimerdev/msearchdata/contents?ref=main)
        .then(response => response.json())
        .then(contents => {
            // Extract content from text files
            const data = contents
                .filter(file => file.type === 'file' && file.name.endsWith('.txt'))
                .map(file => atob(file.content));

            // Perform basic search
            const results = data.filter(item => item.toLowerCase().includes(query.toLowerCase()));

            // Display search results
            displayResults(results);
        })
        .catch(error => console.error('Error fetching data:', error));
}

function displayResults(results) {
    const resultsContainer = document.getElementById('results-container');
    resultsContainer.innerHTML = '';

    if (results.length > 0) {
        const heading = document.createElement('h2');
        heading.textContent = `Search Results for '${document.getElementById('query').value}':`;
        resultsContainer.appendChild(heading);

        const list = document.createElement('ul');
        results.forEach(result => {
            const listItem = document.createElement('li');
            listItem.textContent = result;
            list.appendChild(listItem);
        });

        resultsContainer.appendChild(list);
    } else {
        const noResults = document.createElement('p');
        noResults.textContent = `No results found for '${document.getElementById('query').value}'.`;
        resultsContainer.appendChild(noResults);
    }
}