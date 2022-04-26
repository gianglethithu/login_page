<?php 

$newqueue = new SplQueue();
$newqueue->enqueue("Books");
$newqueue->enqueue("is");
$newqueue->enqueue("great!");
$newqueue->rewind();//point to 0
while($newqueue->valid()){
    echo $newqueue->current(), "\n";
    $newqueue->next();
}
print_r($newqueue);
$newqueue->dequeue();
$newqueue->dequeue();
print_r($newqueue);

$queue = new \Ds\Queue();
$queue->push("a");
$queue->push("bc");
print_r($queue);
?>