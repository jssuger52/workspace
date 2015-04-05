<?php
// Original Custom Type
add_action('init', 'dp_custom_post_type'); 
// Hook before WordPress loaded
function dp_custom_post_type() {
    global $options;

    // ------- News type start --------
    $id = $options['news_cpt_slug_id'] ? $options['news_cpt_slug_id'] : 'news';
    $labels = array(
        'name'          => __('お知らせ', 'DigiPress'), 
        'add_new_item'  => __('新規お知らせを追加', 'DigiPress'),
        'not_found'     =>  __('お知らせは見つかりませんでした。', 'DigiPress'), 
        'new_item'      => __('新しいお知らせ', 'DigiPress'), 
        'view_item'     => __('お知らせを表示', 'DigiPress') 
    );
    $args = array(
        'labels'                => $labels, 
        'public'                => true, //publicly_queriable, show_ui, show_in_nav_menus, exclude_from_search
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'exclude_from_search'   => false,
        'capability_type'       => 'post', 
        'rewrite'               => true,
        'hierarchical'          => false, 
        'has_archive'           => true,
        'menu_position'         => 5, // 5 or 10 or 20
        'supports'              => array(
                                        'title',
                                        'editor',
                                        'thumbnail',
                                        'author',
                                        'excerpt',
                                        'revisions',
                                        'custom-fields'
                                        ) //add_post_type_support()を直接呼び出すエイリアス
    );
    register_post_type($id, $args);
    // ------- News type end --------
}
?>