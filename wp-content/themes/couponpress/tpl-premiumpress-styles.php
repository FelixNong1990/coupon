<?php
/*
Template Name: [PremiumPress Theme Styles]
*/
wp_register_script( 'colorbox',  get_template_directory_uri() .'/PPT/js/jquery.colorbox-min.js');
wp_enqueue_script( 'colorbox' );

wp_register_style( 'colorbox',  get_template_directory_uri() .'/PPT/css/css.colorbox.css');
wp_enqueue_style( 'colorbox' );

function StyleType(){ ?>
 
<br />
<div class="container_12">
 

	<div class="grid_4">
                    
                    <h1>Header One Title (h1)</h1>
                    
                    <h2>Header Two Title (h2)</h2>
                    
                    <h3>Header Three Title (h3)</h3>
                    
                    <h4>Header Four Title (h4)</h4>
                    
                    <h5>H5 Title</h5>
                    
                    <h6>H6 Title</h6>                    
	</div>
    
	<div class="grid_4">
          
       <p><b> Example Paragraph Text</b><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>
                    
       <small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</small>          
                                      
	</div>    
                    
	<div class="grid_4 entry">
                    
 
        <ol class="left">
                    <li>list value</li>
                    <li>list value</li>
                    <li>list value</li>
                    </ol>
                                 
                    <ul class="right">
                    <li>list value</li>
                    <li>list value</li>
                    <li>list value</li>
                    </ul>
                    
     </div>
                    
                    <div class="clearfix"></div>
                    
                    <hr />
                    
                    
<div class="grid_12">
<blockquote class="start">
<p> Fusce lorem magna, blandit vitae dictum quis, suscipit sit amet diam. Cras ipsum justo, pulvinar a interdum vestibulum, suscipit quis purus. Morbi mollis dui neque, at elementum turpis. In vel ultrices ligula. Integer sit amet turpis sem. Fusce sed felis quis augue tempor tincidunt sit amet vel justo.</p>
<p><cite>John F. Kennedy</cite></p>
</blockquote>

<blockquote class="start stop">
<p  class="end-quote"> Fusce lorem magna, blandit vitae dictum quis, suscipit sit amet diam. Cras ipsum justo, pulvinar a interdum vestibulum, suscipit quis purus. Morbi mollis dui neque, at elementum turpis. In vel ultrices ligula. Integer sit amet turpis sem. Fusce sed felis quis augue tempor tincidunt sit amet vel justo.</p>
<p><cite>John F. Kennedy</cite></p>
</blockquote>
</div>

<div class="clearfix"></div>
                    
                    <hr />
                    
 <div class="grid_6">
 
<div class="gray_box">
 
 	 
		<div class="group edge">
			<div class="wrap-ribbon left-edge point stitch lblue"><span>Left Edge Wrap</span></div>
		</div>	
		<div class="group edge">
			<div class="wrap-ribbon right-edge point lblue"><span>Right Edge Wrap</span></div>
		</div>
<div class="gray_box_content">
 Ut congue, nisi ultrices consectetur fringilla, nulla nulla commodo sem, vel cursus dui elit tincidunt arcu. Vivamus tellus risus, bibendum in blandit et, suscipit a lacus. Suspendisse potenti. Fusce vitae mi non arcu laoreet tristique. Cras vel nisl non velit porta blandit. Nam ac lacinia sapien. Vivamus vehicula enim eu tortor venenatis accumsan. Morbi in lacus felis. Proin eget libero mauris, sed auctor mi. Vivamus porta accumsan erat et mattis. In semper tempus pellentesque
</div>
</div>
<div class="blue_box">
<div class="group edge">
			<div class="wrap-ribbon left-edge point lblue"><span>Left Edge Wrap</span></div>
		</div>
         
		<div class="group edge">
			<div class="wrap-ribbon right-edge point stitch lblue"><span>Right Edge Wrap</span></div>
		</div>	
<div class="blue_box_content">
 Ut congue, nisi ultrices consectetur fringilla, nulla nulla commodo sem, vel cursus dui elit tincidunt arcu. Vivamus tellus risus, bibendum in blandit et, suscipit a lacus. Suspendisse potenti. Fusce vitae mi non arcu laoreet tristique. Cras vel nisl non velit porta blandit. Nam ac lacinia sapien. Vivamus vehicula enim eu tortor venenatis accumsan. Morbi in lacus felis. Proin eget libero mauris, sed auctor mi. Vivamus porta accumsan erat et mattis. In semper tempus pellentesque
</div>
</div>

 </div>
 
 <div class="grid_6">
<div class="green_box">
	 <div class="group edge">
			<div class="wrap-ribbon right-edge fork lblue"><span>Right Edge Wrap</span></div>
		</div>	
		 
		<div class="group edge">
			<div class="wrap-ribbon left-edge fork lblue"><span>Left Edge Wrap</span></div>
		</div>	
		 
<div class="green_box_content">
 Ut congue, nisi ultrices consectetur fringilla, nulla nulla commodo sem, vel cursus dui elit tincidunt arcu. Vivamus tellus risus, bibendum in blandit et, suscipit a lacus. Suspendisse potenti. Fusce vitae mi non arcu laoreet tristique. Cras vel nisl non velit porta blandit. Nam ac lacinia sapien. Vivamus vehicula enim eu tortor venenatis accumsan. Morbi in lacus felis. Proin eget libero mauris, sed auctor mi. Vivamus porta accumsan erat et mattis. In semper tempus pellentesque
</div>
</div>
<div class="yellow_box">
	<div class="group corner">
			<div class="wrap-ribbon right-corner strip lblue"><span>Right Corner Wrap</span></div>			
		</div>
        
<div class="group corner">
			<div class="wrap-ribbon left-corner strip lblue"><span>Left Corner Wrap</span></div>			
		</div>
<div class="yellow_box_content">
 Ut congue, nisi ultrices consectetur fringilla, nulla nulla commodo sem, vel cursus dui elit tincidunt arcu. Vivamus tellus risus, bibendum in blandit et, suscipit a lacus. Suspendisse potenti. Fusce vitae mi non arcu laoreet tristique. Cras vel nisl non velit porta blandit. Nam ac lacinia sapien. Vivamus vehicula enim eu tortor venenatis accumsan. Morbi in lacus felis. Proin eget libero mauris, sed auctor mi. Vivamus porta accumsan erat et mattis. In semper tempus pellentesque
</div>
</div>
<div class="red_box">
<div class="group corner">
			<div class="wrap-ribbon left-corner lblue"><span>Left Corner Wrap</span></div>			
		</div>
        	<div class="group corner">
			<div class="wrap-ribbon right-corner lblue"><span>Right Corner Wrap</span></div>
		</div>
<div class="red_box_content">
 Ut congue, nisi ultrices consectetur fringilla, nulla nulla commodo sem, vel cursus dui elit tincidunt arcu. Vivamus tellus risus, bibendum in blandit et, suscipit a lacus. Suspendisse potenti. Fusce vitae mi non arcu laoreet tristique. Cras vel nisl non velit porta blandit. Nam ac lacinia sapien. Vivamus vehicula enim eu tortor venenatis accumsan. Morbi in lacus felis. Proin eget libero mauris, sed auctor mi. Vivamus porta accumsan erat et mattis. In semper tempus pellentesque
</div>

</div>  
 </div>                   
                    
 
                 
</div>


<?php } function StyleTabs(){ ?>



<h3>Page tabs</h3>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

				<hr>

				<div class="container_12">

					<div class="grid_6">

						<h3>Tabs</h3>

						<ol class="tabs">

							<li><a href="#tab11">Tab one</a></li>

							<li><a href="#tab12">Tab two</a></li>

							<li><a href="#tab13">Tab three</a></li> 
						</ol>

						<div class="tab_container">

							<div id="tab11" class="tab_content">

								<h4>Tab one content</h4>

								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

							</div>

							<div id="tab12" class="tab_content">

								<h4>Tab two content</h4>

								<p>Sed ultricies, enim sed ultricies tristique, leo massa cursus ipsum, ut iaculis tortor dui rhoncus purus. Nunc rhoncus porta neque, ut pellentesque vel mollis nulla tellus lobortis id.</p>

								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum.</p>

							</div>

							<div id="tab13" class="tab_content">

								<h4>Tab three content</h4>

								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum.</p>

							</div>

							<div id="tab14" class="tab_content">

								<h4>Tab four content</h4>

								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

							</div>

						</div>

					</div>

					<div class="grid_6">

						<h3>Completely flexible tabs!</h3>

						<ol class="tabs">

							<li><a href="#first">Short</a></li>

							<li><a href="#second">And a really long tab name</a></li>
 

						</ol>

						<div class="tab_container">

							<div id="first" class="tab_content">

								<h4>Tab one content</h4>

								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

							</div>

							<div id="second" class="tab_content">

								<h4>Tab two content</h4>

								<p>Sed ultricies, enim sed ultricies tristique, leo massa cursus ipsum, ut iaculis tortor dui rhoncus purus. Nunc rhoncus porta neque, ut pellentesque vel mollis nulla tellus lobortis id.</p>

								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum.</p>

							</div>

							<div id="third" class="tab_content">

								<h4>Tab three content</h4>

								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum.</p>

							</div>

						</div>

					</div>

				</div>

<hr>

				<div class="container_12">

					<div class="grid_6">

						<h3>Accordion</h3>

						<div class="accordion">

							<div class="trigger"><a href="#">Toggle. Click here to show/hide content</a></div>

							<div class="container">

								<p><b>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</b></p>

								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupid.</p>

							</div>

							<div class="trigger"><a href="#">Toggle. Click here to show/hide content</a></div>

							<div class="container">

								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>

							</div>

							<div class="trigger"><a href="#">Toggle. Click here to show/hide content</a></div>

							<div class="container">

								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>

								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupid.</p>

							</div>

							<div class="trigger"><a href="#">Toggle. Click here to show/hide content</a></div>

							<div class="container">

								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>

								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupid.</p>

							</div>

						</div>

					</div>

					<div class="grid_6">

						<h3>Toggles</h3>

						<div class="toggle">

							<div class="trigger"><a href="#">Toggle. Click here to show/hide content</a></div>

							<div class="container">

								<p><b>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</b></p>

								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis.</p>

							</div>

							<div class="active trigger"><a href="#">Toggle. Click here to show/hide content</a></div>

							<div class="container">

								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>

							</div>

							<div class="trigger"><a href="#">Toggle. Click here to show/hide content</a></div>

							<div class="container">

								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>

								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupid.</p>

							</div>

						</div>

					</div>

				</div>



<?php } 

function StyleNotify(){ ?>

<div class="notification success"><p>This is some random text, this is some random text!</p></div>

    
     <div class="notification error"><p>This is some random text, this is some random text!</p></div>

    <div class="notification warning"><p>This is some random text, this is some random text!</p></div>

    

    <div class="notification neutral"><p>This is some random text, this is some random text!</p></div>

    <div class="notification tip"><p>This is some random text, this is some random text!</p></div>

  
<?php } 

function StyleImages(){ ?>



<div class="container_12">

<div class="padding">

<h2>Image Styles + Pop-up</h2>
</div>
					<div class="grid_3">
						<a class="frame showme" href="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank2.jpg" title="Caption"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank.jpg" alt=""></a>
					</div>
					<div class="grid_3">
						<a class="frame showme" href="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank2.jpg" title="Caption"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank.jpg" alt=""></a>
					</div>
					<div class="grid_3">
						<a class="frame showme" href="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank2.jpg" title="Caption"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank.jpg" alt=""></a>
					</div>
					<div class="grid_3">
						<a class="frame showme" href="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank2.jpg" title="Caption"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank.jpg" alt=""></a>
					</div>

</div>
<div class="container_12">
<div class="padding">
<h2>Image Styles - No Poopup</h2>
</div>	
					<div class="grid_6">
						<div class="frame"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank2.jpg" alt=""></div>
					</div>
					<div class="grid_6">
						<div class="frame"><img src="<?php echo get_template_directory_uri(); ?>/PPT/img/v7/icons/blank2.jpg" alt=""></div>
					</div>
				 
</div>
                
<?php } ?>

<?php function StyleLists(){ ?>

<h3>Icons</h3>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum.</p>

				<br/>

				<div class="container_12">
                

					<div class="grid_3">

						<p class="icon home">Home icon</p>

						<p class="icon phone">Phone icon</p>

					</div>

					<div class="grid_3">

						<p class="icon arrow">Arrow icon</p>

						<p class="icon cross">Cross icon</p>

					</div>

					<div class="grid_3">

						<p class="icon email">Email icon</p>

						<p class="icon favorites">Favorites icon</p>

					</div>

					<div class="grid_3">

						<p class="icon user">User icon</p>

						<p class="icon users">Users icon</p>

					</div>
                    
                    <div class="grid_3">

						<p class="icon rss">RSS icon</p>

						<p class="icon IE">IE icon</p>

					</div>
                    
                    <div class="grid_3">

						<p class="icon twitter">Twitter icon</p>

						<p class="icon IM">IM icon</p>

					</div>
                    
                    <div class="grid_3">

						<p class="icon search">Search icon</p>

						<p class="icon video">Video icon</p>

					</div>
                    
                    <div class="grid_3">

						<p class="icon music">Music icon</p>

						<p class="icon lock">Lock icon</p>

					</div>

				</div>

				<hr/>

				<h3>List styles</h3>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum.</p>

				<br/>

				<div class="container_12">

					<div class="grid_3">

						<h4>Ticklist</h4>

						<ol class="list ticklist">

							<li><span>List item one</span></li>

							<li><span>List item two</span></li>

							<li><span>List item three</span></li>

							<li><span>List item four</span></li>

						</ol>

					</div>

					<div class="grid_3">

						<h4>Crosslist</h4>

						<ol class="list crosslist">

							<li><span>List item one</span></li>

							<li><span>List item two</span></li>

							<li><span>List item three</span></li>

							<li><span>List item four</span></li>

						</ol>

					</div>

					<div class="grid_3">

						<h4>Startlist</h4>

						<ol class="list starlist">

							<li><span>List item one</span></li>

							<li><span>List item two</span></li>

							<li><span>List item three</span></li>

							<li><span>List item four</span></li>

						</ol>

					</div>

					<div class="grid_3">

						<h4>Flaglist</h4>

						<ol class="list flaglist">

							<li><span>List item one</span></li>

							<li><span>List item two</span></li>

							<li><span>List item three</span></li>

							<li><span>List item four</span></li>

						</ol>

					</div>

				</div>

<?php } function StyleButtons(){ ?>

<h3>Colors</h3>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum.</p>

				<a class="green button" href="#">Green Button</a>

				<a class="blue button" href="#">Blue Button</a>

				<a class="purple button" href="#">Purple Button</a>

				<a class="pink button" href="#">Pink Button</a>

				<a class="orange button" href="#">Orange Button</a>

				<a class="yellow button" href="#">Yellow Button</a>

				<a class="gray button" href="#">Gray Button</a>

				<a class="black button" href="#">Black Button</a>

				<hr>

				<div class="container_12">

					<div class="grid_6">

						<h3>Size</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus.</p>

						<a class="fill button green" href="#">A "fill button" fills the parent container</a>

						<br>

						<a class="large button green" href="#">Flexible CSS3 buttons, unlimited width!</a>

					</div>

					<div class="grid_6">

						<h3>Shape</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus.</p>

						<a class="large button green" href="#">Large Button</a>

						<a class="button green" href="#">Normal Button</a>

						<br>

						<br>

						<a class="large rounded button green" href="#">Large & Rounded</a>

						<a class="rounded button green" href="#">Rounded</a>

					</div>

				</div>

				<hr>

				<h3>Buttons with icons</h3>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum.</p>
                
                <div class="clearfix"></div>
 
<?php
$iarray = array ('forward','backward','address', 'adobe', 'aim', 'chart', 'clipboard', 'clock', 'cog', 'comment', 'cross', 'cut', 'date', 'docs',  'down_arrow', 'eject','email','emailnew','facebook','film','heart','home','id','left_arrow','locked','minus','music','pen','photo','play','plus','power','rewind','right_arrow','star','star1','stop','tag','tag2','tick','tv','twitter','unlock','up_arrow','user','users','word','zip','zoom'); 

foreach($iarray as $icon){ ?>

<a class="green button" href="#" style="margin-bottom:5px;">Green Button <img src="<?php echo get_template_directory_uri(); ?>/PPT/img/button/<?php echo $icon; ?>.png" alt=""/></a>

<?php } ?>
                

 



<?php }


function StyleColumns(){ ?>
<div class="container_12"> <!-- one column -->

<div class="grid_12">
<h3>One column</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus. Nullam cursus purus vel velit interdum nec laoreet dolor interdum. Sed ultricies, enim sed ultricies tristique, leo massa cursus ipsum, ut iaculis tortor dui rhoncus purus. Nunc rhoncus porta neque, ut pellentesque vel mollis nulla tellus lobortis id.</p>
                        
 <xmp>
 <div class="grid_12">
<h3>One column</h3>
<p>text here</p>

</div>
 </xmp>                       
                        

					</div>

				</div>

				<hr>

				<div class="container_12"> <!-- two columns -->

					<div class="grid_6">

						<h3>One half</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

					</div>

					<div class="grid_6">

						<h3>One half</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

					</div>

				</div>

				<hr>

				<div class="container_12"> <!-- three columns -->

					<div class="grid_4">

						<h3>One third</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

					</div>

					<div class="grid_4">

						<h3>One third</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

					</div>

					<div class="grid_4">

						<h3>One third</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Morbi at purus urna, sit amet rutrum lectus.</p>

					</div>

				</div>

				<hr>

				<div class="container_12"> <!-- four columns -->

					<div class="grid_3">

						<h3>One fourth</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque.</p>

					</div>

					<div class="grid_3">

						<h3>One fourth</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque.</p>

					</div>

					<div class="grid_3">

						<h3>One fourth</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque.</p>

					</div>

					<div class="grid_3">

						<h3>One fourth</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque.</p>

					</div>

				</div>

				<hr>

				<div class="container_12"> <!-- 1/4 - 3/4 -->

					<div class="grid_9">

						<h3>Three fourths</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Nulla eget odio justo, vel mollis nulla. Nam vehicula risus sit amet nisi volutpat sed pharetra enim pellentesque. Maecenas elementum bibendum porta. Sed ultricies, enim sed ultricies tristique, leo massa cursus ipsum, ut iaculis tortor dui rhoncus purus. Nunc rhoncus porta neque, ut pellentesque vel mollis nulla tellus lobortis id.</p>

					</div>

					<div class="grid_3">

						<h3>One fourth</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus.</p>

					</div>

				</div>

				<hr>

				<div class="container_12"> <!-- 2/3 - 1/3 -->

					<div class="grid_4">

						<h3>One third</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque.</p>

					</div>

					<div class="grid_8">

						<h3>Two thirds</h3>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla a sapien diam, bibendum tincidunt purus. Morbi feugiat, augue in luctus lobortis, purus ipsum scelerisque metus, vitae posuere mi turpis tristique neque. Nulla eget odio justo, vel mollis nulla. Nam vehicula risus sit amet nisi volutpat sed pharetra enim pellentesque. Maecenas elementum bibendum porta. Sed ultricies, enim sed ultricies tristique, leo massa cursus ipsum, ut iaculis tortor dui rhoncus purus. Nunc rhoncus porta neque, ut pellentesque vel mollis nulla tellus lobortis id.</p>

					</div>

				</div>
 
<?php } 







global  $userdata; get_currentuserinfo(); // grabs the user info and puts into vars

$wpdb->hide_errors(); nocache_headers(); 

// premiumpress_authorize(); <-- uncomment if you want this to be a page for members only
 
$GLOBALS['nosidebar-left'] =1; $GLOBALS['nosidebar-right'] =1;

get_header();  ?>
<style>.padding10 { padding:0px !important; }

#content {
background: white;
clear: both;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
border-radius: 4px;
-moz-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
-webkit-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
}


/* =tabs */
 

 </style>



 

<div id="begin" class="inner" style="margin-top:10px;">

	 <?php echo $PPTDesign->breadcrumbs(); ?>
 

	<h2>PremiumPress Styles Overview</h2>

	<ol class="page_tabs">
    
    	<li><a href="#tab0">Typography</a></li>

		<li><a href="#tab1">Buttons</a></li>

		<li><a href="#tab2">Columns</a></li>

		<li><a href="#tab3">Icons</a></li>

		<li><a href="#tab4">Images</a></li>

		<li><a href="#tab5">Notification boxes</a></li>

		<li><a href="#tab6">Tabs</a></li>

	</ol>

</div> <!-- begin -->

 
<div class="tab_container">


    <div id="tab0" class="page_content  nopadding">
    <?php  StyleType(); ?>
    </div>
    
    <!-- end tab 0 -->
 
    <div id="tab1" class="page_content">
    <?php  StyleButtons(); ?>
    </div>
    
    <!-- end tab 1 -->
    
    <div id="tab2" class="page_content nopadding">
    <?php StyleColumns(); ?> 
    </div>
    
    <!-- end tab 2 -->
    
    <div id="tab3" class="page_content">
    <?php StyleLists(); ?> 
    </div>
    
    <!-- end tab 3 -->
    
    <div id="tab4" class="page_content nopadding">
    <?php StyleImages(); ?> 
    </div>
    
    <!-- end tab 4 -->
    
    <div id="tab5" class="page_content">
    <?php StyleNotify(); ?> 
    </div>
    
    <!-- end tab 5 -->
    
    <div id="tab6" class="page_content">
    <?php StyleTabs(); ?> 
    </div>
    
    <!-- end tab 6 -->


</div>

<div class="enditembox inner">
<a class="button blue" href="javascript:void(0);" onclick="alert('This is just an example button. It doesnt do anything sorry.');">&laquo; Previous</a>
<a class="button blue right" href="javascript:void(0);" onclick="alert('This is just an example button. It doesnt do anything sorry.');">Next &raquo; </a>
</div>  
 
 
<script language="javascript">
jQuery(document).ready(function(){
 
/* apply jobs actions */
jQuery(".showme").colorbox();
	 
				
}); 
</script>
    
 
<?php get_footer(); ?>