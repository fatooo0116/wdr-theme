<?php
/**
 * Created by WDr co.
 * User: Wade Hsu.
 * Date: 2015/7/23
 * Description: theme setting
 */



add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {


    add_menu_page('My Cool Plugin Settings', 'Cool Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );
    add_action( 'admin_init', 'register_my_cool_plugin_settings' );
}


function register_my_cool_plugin_settings() {

    register_setting( 'my-cool-plugin-settings-group', 'new_option_name' );
    register_setting( 'my-cool-plugin-settings-group', 'some_other_option' );
    register_setting( 'my-cool-plugin-settings-group', 'option_etc' );
}



function my_cool_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h2>Your Plugin Name</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'my-cool-plugin-settings-group' ); ?>
            <?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>


            <div ng-app="myapp" ng-controller="myctrl">

                <p>Name: <input type="text" ng-model="firstName"></p>
                <p>You wrote: {{ firstName }}</p>

            </div>

            <script>
                var app = angular.module("myapp",[]);
                app.controller("myctrl",function($scope,$http,$timeout){
                    //$scope.firstName  = firstName;








                    var req = {
                        method: 'POST',
                        url: '<?php echo admin_url('admin-ajax.php' );?>',
                        headers: {
                            'Content-Type':'application/json'
                        },
                        params: {
                            action: 'wdr_ajax_get'
                        }
                    }

                    $http(req).success(function(data){

                            $scope.firstName = data;

                            console.log(data);

                        }).error(function(){
                            console.log("error");
                        });


                });



                (function($){
                    $.post('<?php echo admin_url('admin-ajax.php' );?>', {
                        action: 'wdr_ajax_get',
                    }, function(data) {
                        console.log(data); // 當AJAX處理完畢，就把回傳的資料alert出來
                    });
                })(jQuery);


            </script>
            <?php submit_button(); ?>
        </form>
    </div>
<?php }



add_action( 'wp_ajax_wdr_ajax_get', 'wdr_ajax_fun' ); // 針對已登入的使用者
add_action( 'wp_ajax_nopriv_wdr_ajax_get', 'wdr_ajax_fun' ); // 針對未登入的使用者
function wdr_ajax_fun() {

    

// Force a short-init since we just need core WP, not the entire framework stack
    define( 'SHORTINIT', true );

// Build the wp-load.php path from a plugin/theme
    $wp_root_path = dirname( dirname( dirname( __FILE__ ) ) );
// Require the wp-load.php file (which loads wp-config.php and bootstraps WordPress)
    // require( $wp_root_path . '/wp-load.php' );


   global $wpdb;


    $app = array(
        "xx1"=>1,
        "xx2"=>2
    );
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($app);




    wp_die();
}

?>
