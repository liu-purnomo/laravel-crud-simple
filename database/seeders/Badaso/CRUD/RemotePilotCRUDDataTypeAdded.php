<?php

namespace Database\Seeders\Badaso\CRUD;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Facades\Badaso;
use Uasoft\Badaso\Models\MenuItem;

class RemotePilotCRUDDataTypeAdded extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     *
     * @throws Exception
     */
    public function run()
    {
        \DB::beginTransaction();

        try {

            $data_type = Badaso::model('DataType')->where('name', 'remote_pilot')->first();

            if ($data_type) {
                Badaso::model('DataType')->where('name', 'remote_pilot')->delete();
            }

            \DB::table('badaso_data_types')->insert(array (
                'name' => 'remote_pilot',
                'slug' => 'remote-pilot',
                'display_name_singular' => 'Remote Pilot',
                'display_name_plural' => 'Remote Pilot',
                'icon' => 'account_circle',
                'model_name' => NULL,
                'policy_name' => NULL,
                'controller' => NULL,
                'order_column' => NULL,
                'order_display_column' => NULL,
                'order_direction' => NULL,
                'generate_permissions' => true,
                'server_side' => false,
                'description' => NULL,
                'details' => NULL,
                'notification' => '[]',
                'is_soft_delete' => false,
                'updated_at' => '2022-05-23T14:50:03.000000Z',
                'created_at' => '2022-05-23T14:50:03.000000Z',
                'id' => 1,
            ));

            Badaso::model('Permission')->generateFor('remote_pilot');

            $menu = Badaso::model('Menu')->where('key', config('badaso.default_menu'))->firstOrFail();

            $menu_item = Badaso::model('MenuItem')
                ->where('menu_id', $menu->id)
                ->where('url', '/general/remote-pilot')
                ->first();

            $order = Badaso::model('MenuItem')->highestOrderMenuItem($menu->id);

            if (!is_null($menu_item)) {
                $menu_item->fill([
                    'title' => 'Remote Pilot',
                    'target' => '_self',
                    'icon_class' => 'account_circle',
                    'color' => null,
                    'parent_id' => null,
                    'permissions' => 'browse_remote_pilot',
                    'order' => $order,
                ])->save();
            } else {
                $menu_item = new MenuItem();
                $menu_item->menu_id = $menu->id;
                $menu_item->url = '/general/remote-pilot';
                $menu_item->title = 'Remote Pilot';
                $menu_item->target = '_self';
                $menu_item->icon_class = 'account_circle';
                $menu_item->color = null;
                $menu_item->parent_id = null;
                $menu_item->permissions = 'browse_remote_pilot';
                $menu_item->order = $order;
                $menu_item->save();
            }

            \DB::commit();
        } catch(Exception $e) {
            \DB::rollBack();

           throw new Exception('Exception occur ' . $e);
        }
    }
}
