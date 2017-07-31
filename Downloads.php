<?php

class Downloads {

    protected $width;

    /**
     * Downloads constructor
     *
     * @param $columns
     * @internal param int $width
     */
    public function __construct($columns) {
        $this->width = $this->widthConverter($columns);
    }

    /**
     * Converts column numbers to flexboxgrid/bootstrap
     *
     * Defaults to 3 columns
     *
     * @param $columns int
     *
     * @return int
     */
    private function widthConverter($columns) {
        switch ($columns) {
            case 1:
                return 12;
                break;
            case 2:
                return 6;
                break;
            case 3:
                return 4;
                break;
            case 6:
                return 2;
                break;
            case 12:
                return 1;
                break;
            default:
                return 4;
        }
    }


    /**
     * For showing/hiding block
     *
     * @return bool
     */
    public function isThereDownloads() {
        $query = new WP_Query(array('post_type' => 'downloads'));

        if ($query->have_posts() === TRUE) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @return string
     */
    public function callDownloadsLoop() {
        $args = array(
            'post_type' => 'downloads',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        $query = new WP_Query($args);
        while ($query->have_posts()) : $query->the_post(); ?>

            <div class="col-sm-<?php echo $this->width; ?>">
                <div class="downloads-img">
                    <a href="<?php echo the_field('downloads_download'); ?>" download>
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail();
                        }
                        else {
                            ?>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/images/na.png'; ?>" style="width: 220px;" />
                            <?php
                        }
                        ?>
                    </a>
                </div>

                <div class="downloads-text">

                    <h2><?php the_title(); ?></h2>
                    <?php if (has_excerpt()) : the_excerpt(); endif; ?>

                </div>
            </div>

        <?php endwhile;
    }

}