<?php 
// open this directory 
$myDirectory = opendir("log");
// get each entry
while($entryName = readdir($myDirectory)) {
    $dirArray[] = "log/$entryName";
}
// close directory
closedir($myDirectory);
//  count elements in array
$indexCount = count($dirArray);
Print ("" . ($indexCount -2) . "  files<br>\n");
// sort 'em
sort($dirArray);
// print 'em
print("<TABLE border=1 cellpadding=5 cellspacing=0 class=whitelinks>\n");
print("<TR><TH>Filename</TH><th>Filetime</th><th>Filesize</th></TR>\n");
// loop through the array of files and print them all
for($index=0; $index < $indexCount; $index++) 
{
    if (substr("$dirArray[$index]", 4, 1) != ".")
    { // don't list hidden files
        print("<TR><TD><a href=\"$dirArray[$index]\">$dirArray[$index]</a></td>");
        print("<td>");  print(date ("F d Y H:i:s.",filemtime($dirArray[$index]))); print("</td>");
        print("<td>");  print(filesize($dirArray[$index])); print("</td>");
        print("</TR>\n");
    }
}
print("</TABLE>\n");
?>