jQuery(document).ready(function() {
	jQuery('body').on('click','.jm-post-like',function(event){
		event.preventDefault();
		heart = jQuery(this);
		hearts = jQuery( '.jm-post-like', jQuery(this).closest('.post'))
		post_id = heart.data("post_id");
		heart.addClass('loading');
		heart.html("<i id='icon-like' class='fa fa-heart'></i><i id='icon-gear' class='fa fa-spin fa-cog'></i>");
		jQuery.ajax({
			type: "post",
			url: ajax_var.url,
			data: "action=jm-post-like&nonce="+ajax_var.nonce+"&jm_post_like=&post_id="+post_id,
			success: function(count){
				heart.removeClass("loading");
				if( count.indexOf( "already" ) !== -1 )
				{
					var lecount = count.replace("already","");
					if (lecount === "0")
					{
						lecount = "";
					}
					hearts
						.prop('title', 'Like')
						.removeClass("liked")
						.html("<i id='icon-unlike' class='fa fa-heart'></i><span>&nbsp;"+lecount+"</span>");
				}
				else
				{
					hearts
						.prop('title', 'Unlike')
						.addClass("liked")
						.html("<i id='icon-like' class='fa fa-heart-o'></i><span>&nbsp;"+count+"</span>");
				}
			}
		});
	});
});
