<?php
class Song
{
    public $title;
    public $artist;
    public $duration;
    public $year;

    public function __construct($title, $artist, $duration, $year)
    {
        $this->title = $title;
        $this->artist = $artist;
        $this->duration = $duration;
        $this->year = $year;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getFullInfo()
    {
        return "{$this->title}, {$this->artist}, {$this->duration}, {$this->year}";
    }
}

class TreeNode
{
    public $song;
    public $left;
    public $right;

    public function __construct($song)
    {
        $this->song = $song;
        $this->left = null;
        $this->right = null;
    }
}

class BST
{
    public $root;

    public function __construct()
    {
        $this->root = null;
    }

    public function insert($song)
    {
        $this->root = $this->_insertRecursive($this->root, $song);
    }

    private function _insertRecursive($node, $song)
    {
        if ($node === null) {
            return new TreeNode($song);
        }

        $compare = strcmp(strtolower($song->getTitle()), strtolower($node->song->getTitle()));
        if ($compare < 0) {
            $node->left = $this->_insertRecursive($node->left, $song);
        } elseif ($compare > 0) {
            $node->right = $this->_insertRecursive($node->right, $song);
        }

        return $node;
    }

    public function search($title)
    {
        return $this->_searchRecursive($this->root, $title);
    }

    private function _searchRecursive($node, $title)
    {
        if ($node === null || strtolower($node->song->getTitle()) === strtolower($title)) {
            return $node;
        }

        $compare = strcmp(strtolower($title), strtolower($node->song->getTitle()));
        if ($compare < 0) {
            return $this->_searchRecursive($node->left, $title);
        } else {
            return $this->_searchRecursive($node->right, $title);
        }
    }
}

$bst = new BST();
$file = fopen("allSongs.txt", "r");
if ($file) {
    while (($line = fgets($file)) !== false) {
        $data = explode(", ", $line);
        if (count($data) >= 4) {
            $title = preg_replace("/^\d+\.\s+/", "", $data[0]);
            $artist = $data[1];
            $duration = intval($data[2]);
            $year = intval($data[3]);
            $song = new Song($title, $artist, $duration, $year);
            $bst->insert($song);
        }
    }
    fclose($file);
} else {
    echo "Error opening the file.";
    exit();
}

while (true) {
    echo "Enter a song title to search for (or 'exit' to quit): ";
    $searchTitle = trim(readline());

    if ($searchTitle === 'exit') {
        break;
    }

    $result = $bst->search($searchTitle);

    if ($result !== null) {
        $foundSong = $result->song;
        echo "Song found: " . $foundSong->getFullInfo() . PHP_EOL;
    } else {
        echo "Song '$searchTitle' not found in the BST." . PHP_EOL;
    }
}

echo "Exiting the program...";
?>
