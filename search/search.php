<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        h2 {
            color: #1a0dab;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background-color: #fff;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<?php
// GitHub repository details
$owner = 'drimerdev';
$repo = 'msearchdata';
$branch = 'main'; // or any other branch you want to fetch data from

// Get user input from the form
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Fetch data from GitHub repository
$url = "https://api.github.com/repos/drimerdev/msearchdata/contents";
$contents = json_decode(file_get_contents($url . "?ref=$branch"), true);

// Extract content from text files
$data = array();
foreach ($contents as $file) {
    if ($file['type'] === 'file' && pathinfo($file['name'], PATHINFO_EXTENSION) === 'txt') {
        $content = base64_decode(json_decode(file_get_contents($file['url']), true)['content']);
        $data[] = $content;
    }
}

// Perform basic search
$results = array_filter($data, function($item) use ($query) {
    return stripos($item, $query) !== false;
});

// Display search results
if (!empty($results)) {
    echo "<h2>Search Results for '$query':</h2>";
    echo "<ul>";
    foreach ($results as $result) {
        echo "<li>$result</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No results found for '$query'.</p>";
}
?>

</body>
</html>