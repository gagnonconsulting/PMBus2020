<?php

/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>
@media only screen and (max-width: 600px) {
	.mobileShow {
  	width: 33%;
	}
	.phone_display {
		width:200px;
	}
	.phone_display_link {
		width:50px;
	}
	.phone_display_table {
		margine-left: -100px;
	}
}

.up {

	display: inline;
	width:15px;
	height:15px;
	padding-left: 5px;

}

.gci_product_table th {
	font-size: 0.9em;
	border-width: 0;
	border-color: black;
}
.productInfoTD {
	font-size: 0.9em;
	cursor: pointer;
	border-style: solid;
	border-width: 1px;
	border-color: black;
	width: 6%;
}

.arrowSpan {
		margin-left: -6px;
		white-space:nowrap;
}

.units {
	font-size: .7em;
}
</style>

<?php
global $wpdb;
global $wp_query;
$term_id = $_POST['term_id'];
//echo "<h2> term_id = ".$term_id."</h2>";

$tableTitle = $wpdb->get_results(
	"SELECT slug FROM `wp_terms` WHERE term_id = '$term_id'"
);
$page_title = $tableTitle[0]->slug;
//echo "<h2>page_title is ".$page_title."</h2>";


$GLOBALS['gci_table_name'] = $page_title . '_table';;

//$GLOBALS['gci_table_name'] = $GLOBALS['gci_table_name'] . '_table';
$table_id = $GLOBALS['gci_table_name'];
//echo $table_id;
$localTableId = '</a>' . $table_id . '<a>';
//echo $localTableId;


$nanProductTableLocal = $GLOBALS['nanProductTable'];
$phaseProductTablesLocal = $GLOBALS['phaseProductTables'];
$outputProductTablesLocal = $GLOBALS['outputProductTables'];

//echo htmlspecialchars($table_id);
?>

	<div>
	<?php $page_template = get_page_template_slug( get_queried_object_id() ); ?>
		<table style="width: 100%; table-layout: fixed;" id="<?php echo $table_id ?>"
			class="gci_product_table phone_display_table">
		<thead>
			<tr>
			<?php
			//Checks if the table ID is predefined as a table without power min/max and voltage in/out
			// or is a company page, which does not need these extra columns

			// If Products by Company
			if ((substr($page_title, 0,8) === 'company-')) {
				//echo $page_title;
				?>
				<th width="20%" style="cursor:pointer;" onclick="sortTable(1, '<?php echo $table_id ?>')"
					class="gci_hide" style="border-style: solid; border-width: 1px; border-color: black;">&#8645;Category /</br>Sub-Category</th>
				<th width="20%" style="cursor:pointer;" onclick="sortTable(2, '<?php echo $table_id ?>')"
					class="gci_hide" style="border-style: solid; border-width: 1px; border-color: black;">&#8645;Product ID</th>
				<th width="40%" class="gci_hide">Description</th>
				<th width="20%" style="cursor:pointer;" class="gci_hide"></th>
			<?php
			}
			// If Products by Category with no extra columns
			elseif (in_array($localTableId, $nanProductTableLocal)) { ?>
				<th width="20%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(0, '<?php echo $table_id ?>')" class="gci_hide">&#8645;Company</th>
				<th width="20%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(1, '<?php echo $table_id ?>')" class="gci_hide"
					style="border-style: solid; border-width: 1px; border-color: black;">&#8645;Product ID</th>
				<th width="60%" class="gci_hide">Description</th>
			<?php
			}
			// If Products by Category with Phase column
			elseif (in_array($localTableId, $phaseProductTablesLocal)) { ?>
				<th width="20%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(0, '<?php echo $table_id ?>')" class="gci_hide">&#8645;Company</th>
				<th width="20%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(1, '<?php echo $table_id ?>')" class="gci_hide"
					style="border-style: solid; border-width: 1px; border-color: black;">&#8645;Product ID</th>
				<th width="40%" class="gci_hide">Description</th>
				<th width="20%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(3, '<?php echo $table_id ?>')" class="gci_hide">&#8645;Phase</th>
			<?php
			}
			// If Products by Category with Phase & Output columns
			elseif (in_array($localTableId, $outputProductTablesLocal)) { ?>
				<th width="20%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(0, '<?php echo $table_id ?>')" class="gci_hide">&#8645;Company</th>
				<th width="20%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(1, '<?php echo $table_id ?>')" class="gci_hide"
					style="border-style: solid; border-width: 1px; border-color: black;">&#8645;Product ID</th>
				<th width="30%" class="gci_hide">Description</th>
				<th width="15%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(3, '<?php echo $table_id ?>')" class="gci_hide">&#8645;Phase</th>
				<th width="15%" class="phone_display gci_product_table_sortable" style="cursor:pointer;"
					onclick="sortTable(4, '<?php echo $table_id ?>')" class="gci_hide">&#8645;Output</th>
			<?php
			}
			else {
				// If Products by Category with Power (min & max & unit) and Voltage (min & max & unit) columns
				?>
				<!-- <th width="10%" class="gci_hide">Image</th> -->
				<th width="20%" class="phone_display gci_product_table_sortable"
					onclick="sortTable(0, '<?php echo $table_id ?>')"><span style="white-space:nowrap;" >&#8645;Company</span></th>
				<th width="20%" class="phone_display gci_product_table_sortable mobileShow"
					onclick="sortTable(1, '<?php echo $table_id ?>')"><span style="white-space:nowrap;">&#8645;Product ID</span></th>
				<th width="22%" class="gci_hide">Description</th>
				<th width="6%" class="productInfoTD"
					onclick="sortTableNum(3, '<?php echo $table_id ?>')"><span class="arrowSpan">&#8645;P<br><span class="units">min</span></span></th>
				<th width="6%" class="productInfoTD max"
					onclick="sortTableNum(4, '<?php echo $table_id ?>')"><span class="arrowSpan">&#8645;P<br><span class="units">max</span></span></th>
				<th width="4%" class="productInfoTD" ><span class="arrowSpan"></span></th>
				<th width="6%" class="productInfoTD"
					onclick="sortTableNum(6, '<?php echo $table_id ?>')"><span class="arrowSpan">&#8645;V<br><span class="units">min</span></span></th>
				<th width="6%" class="productInfoTD max"
					onclick="sortTableNum(7, '<?php echo $table_id ?>')"><span class="arrowSpan">&#8645;V<br><span class="units">max</span></span></th>
				<th width="4%" class="productInfoTD" s><span class="arrowSpan"></span></th>
			<?php } ?>
			</tr>
	</thead>

<?php
