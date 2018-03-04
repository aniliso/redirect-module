<?php

namespace Modules\Redirect\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterRedirectSidebar extends AbstractAdminSidebar
{
    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('redirect::redirects.title.redirects'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('redirect::reports.title.reports'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.redirect.report.create');
                    $item->route('admin.redirect.report.index');
                    $item->authorize(
                        $this->auth->hasAccess('redirect.reports.index')
                    );
                });
                $item->item(trans('redirect::redirects.title.redirects'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.redirect.redirect.create');
                    $item->route('admin.redirect.redirect.index');
                    $item->authorize(
                        $this->auth->hasAccess('redirect.redirects.index')
                    );
                });
// append


            });
        });

        return $menu;
    }
}
