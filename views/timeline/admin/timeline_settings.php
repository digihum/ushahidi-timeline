<table style="width: 630px;" class="my_table">
	<tr>
		<td>
			<h4 class="fix">Timeline Interval</h4>
			<div class="row">
				<?php print form::dropdown('timeline_interval', array("Monthly","Bi-Monthly","Tri-Monthly","Four Monthly","Half Yearly","Yearly"), $form['timeline_interval'], ' class="text title_2"'); ?>
			</div>
		</td>
	</tr>						
</table>