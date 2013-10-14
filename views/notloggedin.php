<!--
Jamie Tahirkheli
006547398
CS 174
-->
<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" >
<!--
Jamie Tahirkheli - 006547398
Zohaib Khan - 007673133
CS 174
-->
<table>
    <tr>
        <td>
            <h2 STYLE="WIDTH: 1000px">
                <?php 
                    $parent_dir = dirname(__FILE__) . '/..';
                    include_once($parent_dir . "/config/config.php");
                    include_once($parent_dir."/controllers/main.php");
                    include_once($parent_dir . "/controllers/login.php");
                    //blog title
                    echo $data['title'];
                    echo $data['pagetitle'];
                ?>
                <br/>
            </h2>
        </td>
        <td STYLE="WIDTH: 1500px">
            <div STYLE="position:absolute; 
                TOP:10px; RIGHT:80px;">
                <?php
                //loginLink
                echo $data['logLink'];
                ?>
            </div>
        </td>
    </tr>  
    <tr>
        <td>
           <div STYLE="WIDTH: 1000px">
              <?php 
              //blog text
              echo $data['blogText'];
              ?>
              <br/>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="comment">
                <br/>
                <?php
                //form for comments
                echo $data['commentForm'];
                echo $data['comments'];
                ?>
            </div>
        </td>
        <td>
            <?php
            echo $data['previous'];
            ?>
            <div >
                <?php
                echo $data['bloglist'];
                ?>
            </div>
        </td>
    </tr>
</table>
</html>