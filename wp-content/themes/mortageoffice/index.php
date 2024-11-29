<?php
/*
The Falling and the Rising Rain

Two monks were arguing about the best way to implement two somewhat-similar
workflows in their application. They went to the visiting master Suku to
settle their dispute.

The first monk said, “I believe we should implement both workflows separately
to keep them from constraining each other. When all work is done we can
identify the common parts, and combine them into generic base classes or
utilities. If similar workflows are desired in the future, we will follow
this process: design each new flow independently, make use of the generic
code where possible, and combine workflow-specific code into generic
implementations when appropriate.”

Suku said to the first monk, “This is a most natural approach. When it rains
on the mountain, tiny droplets cascade down the stones. As the waters descend
into the valley, ten thousand rivulets merge into a thousand brooks, then a
hundred creeks, then ten streams, then one mighty river.”

The second monk said, “I believe we should implement both workflows together,
using their features to define a generic framework. When special cases or
alternate flows arise, we can abstract them out as configurable features, or
add hooks into the framework as appropriate. If similar workflows are desired
in the future, we will follow this process: implement each new flow using the
framework, and if this proves impossible, split the framework’s generic
implementations to allow workflow-specific code as needed.”

Suku said to the second monk, “This also is a natural approach. When it rains
on the mountain, tiny droplets nourish the roots of the sapling. As the
mighty oak ascends toward the heavens, one trunk divides into ten boughs,
then a hundred limbs, then a thousand branches, then ten thousand twigs.”

Both monks bowed and turned to leave—their argument still unsettled—whereupon
Suku sighed in frustration and rapped the backs of their heads with her staff.

“Monks!” she said to the pair. “If the world were wiped clean except for
mountains and rain, which would arise first: the river, or the oak tree?”

http://thecodelesscode.com/case/233
*/

global $post;
get_header();

$qo = get_queried_object();

do_action('before_archive_loop', $qo);

$archive_post_classes = ['archive-posts', 'alignwide'];
$archive_post_classes = apply_filters('archive_loop_classes', $archive_post_classes, $qo);
?>
<section class="<?php echo implode(' ', $archive_post_classes); ?>">
	<?php
	$post_index = 1;
	while (have_posts()) {
		the_post();
		do_action('before_archive_post', $post, $post_index);
		do_action('the_archive_post', $post);
		do_action('after_archive_post', $post, $post_index);
		$post_index++;
	}
	?>
</section>
<?php
do_action('after_archive_loop', $qo);

get_footer();
