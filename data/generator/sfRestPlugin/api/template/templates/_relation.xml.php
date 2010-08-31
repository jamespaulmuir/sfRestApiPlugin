<[?php echo $alias; ?]>
[?php foreach($object as $value):?]
[?php include_partial('object',array('object'=>$value)); ?]
[?php endforeach;?]
</[?php echo $alias; ?]>