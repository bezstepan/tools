<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<?php
$import = glob("codes/*.*");
$export = array();
for ($i=2; $i<sizeof($import); $i++) {
    array_push($export, $import[1]);
    array_push($export, $import[$i]);
}
?>
<img id="thisImg" alt="img" src="codes/none.jpg"/>
<script type="text/javascript">
    $(function(){
        var dataArray=<?php echo json_encode($export); ?>;

        var thisId=0;

        window.setInterval(function(){
            $('#thisImg').attr('src',dataArray[thisId]);
            thisId++; //increment data array id
            if (thisId==dataArray.length()) thisId=0; //repeat from start
        },2000);        
    });
</script>