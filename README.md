dmAccordionBehaviorPlugin for Diem Extended
===============================

Author: [TheCelavi](http://www.runopencode.com/about/thecelavi)  
Version: 1.0.0  
Stability: Stable  
Date: November 10th, 2012  
Courtesy of [Run Open Code](http://www.runopencode.com)   
License: [Free for all](http://www.runopencode.com/terms-and-conditions/free-for-all)

dmAccordionBehaviorPlugin for Diem Extended is simple accordion UI control.

Usage
-------------
The simplest and most easiest way to use accordion is to add widgets
into zone, and attach dmAccordionBehaviorPlugin to the zone. The behavior 
will make every odd widget into accordion header end every even widget 
into accordion content.

However, it can work with any HTML element with following structure:

	<container>
		<acc-header></acc-header>
		<acc-content></acc-content>
		<acc-header></acc-header>
		<acc-content></acc-content>
		.....
	</container>

In order to achieve that, you have to specify the `Inner target` selector
for `<container>` tag so accordion can identify it and headers and contents
as well.

Note that in this example tags such as `container`, `acc-header` and `acc-content`
are just examples, of course, any HTML structure will work, like using `DIV` or 
perhaps `UL` and `LI`

HTML output
---------------
The behavior will not change structure, it will only add some CSS classes to the 
tags.

	<container class="dmAccordionBehavior theme">
		<acc-header class="accordion-title accordion-title-index-0 open"></acc-header>
		<acc-content class="accordion-content accordion-content-index-0 open"></acc-content>
		<acc-header class="accordion-title accordion-title-index-1 closed"></acc-header>
		<acc-content class="accordion-content accordion-content-index-1 closed"></acc-content>
		<acc-header class="accordion-title accordion-title-index-2 closed"></acc-header>
		<acc-content class="accordion-content accordion-content-index-2 closed"></acc-content>		
		.....
	</container>
	
Note `theme` class at `<container>` tag - it will be the name of the theme that
you have selected in behavior configuration form. In that matter you can style 
the accordion.
	
	
	
	
	
	
	
	
	
	
	
	
	