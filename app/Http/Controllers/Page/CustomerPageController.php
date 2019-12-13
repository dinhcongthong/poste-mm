<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use HTML;

class CustomerPageController extends Controller {
    protected $view_str = '';

    public function getCustomer($seg1 = '', $seg2 = '', $seg3 = '') {
        switch($seg1) {
            case 'fuji-real-estate': {
                $this->fuji_real_estate();
                break;
            }
            case 'ishikawashoji': {
                $this->ishikawashoji();
                break;
            }
            case 'vrmyanmar': {
                $this->vrmyanmar();
                break;
            }
            case 'azumaya-massage': {
                $this->azumaya_massage();
                break;
            }
            default: {
                $this->data['pageTitle'] = 'Page Not Found | ' . $this->data['pageTitle'];
                return view('errors.404')->with($this->data);
            }
        }

        $this->data['pageType'] = 'article';

        return view($this->view_str)->with($this->data);
    }

    public function fuji_real_estate() {
        $this->data['pageTitle'] = 'Fuji Real Estate | 取扱件数最多、日本語対応でお部屋探しを安心サポート';
        $this->data['pageDescription'] = 'ミャンマーで外国人が不動産を借りる場合には規制が厳しく、不便に感じることも多いはず。不動産選びや手続きが難しいミャンマーで、Fuji不動産はスタッフが物件探しから、契約手続き、アフタフォローまで全て日本語で安心サポートします。格安・高級物件や商業・工業用物件まで取り揃えているため、様々な要望に対応します。ミャンマー最多の取り扱い件数の中からあなたの要望や予算にあった最適な物件をご提案します。';
        $this->data['pageKeywords'] = 'Fuji不動産、ミャンマー、不動産、日本語対応、日本人';
        $this->data['pageImage'] = asset('customer/fuji_real_estate/top1.jpg');

        $this->data['stylesheets'] .=
        HTML::style('vendors/swiper/css/swiper.min.css').
        HTML::style('customer/fuji_real_estate/fuji_real_estate.css');

        $this->data['scripts'] .= '';

        $this->view_str = 'www.customer.fuji_real_estate';
    }

    public function ishikawashoji() {
        $this->data['pageTitle'] = '石川商事｜ヤンゴンでお部屋探し＆オフィス探し中の方必見';
        $this->data['pageDescription'] = ' ヤンゴンでサービスアパートメントやコンドミニアム、土地、一戸建て、商業ビルをお探しの方は石川商事にご相談ください!! あなたが満足できる物件が見つかるまで丁寧に日本人スタッフがお手伝いします。';
        $this->data['pageKeywords'] = 'ミャンマー,ヤンゴン,マンダレー,ネピドー,不動産,部屋探し,サービスアパートメント,コンドミニアム,土地,一戸建て,商業ビル';
        $this->data['pageImage'] = asset('customer/ishikawashoji/main.jpg');

        $this->data['stylesheets'] .=
        HTML::style('customer/ishikawashoji/ishikawashoji.css');

        $this->data['scripts'] .='';

        $this->view_str = 'www.customer.ishikawashoji';
    }

    public function vrmyanmar() {
        $this->data['pageTitle'] = 'VRミャンマー｜ミャンマーでお部屋探しなら！';
        $this->data['pageDescription'] = 'ミャンマーでお部屋探しならVRミャンマーをご利用ください！ 弊社は24時間日本語サポートを行っており安心して暮らしていただけます。弊社の取扱っているサービスアパート以外にも、ホテルやコンドミニアムのご紹介もさせていただいており、初めてミャンマーに住まれる予定の方にも快適な生活をしていただけます！';

        $this->data['pageKeywords'] = 'ヤンゴン,不動産,VRミャンマー,サービスアパートメント,VICTORYRESIDENCE';

        $this->data['pageImage'] = asset('customer/vrmyanmar/main.jpg');

        $this->data['stylesheets'] .=
        HTML::style('customer/vrmyanmar/vrmyanmar.css');

        $this->data['scripts'] .='';

        $this->view_str = 'www.customer.vrmyanmar';
    }

    public function azumaya_massage() {
        $this->data['pageTitle'] = '東屋マッサージ（Azumaya Massage）｜ヤンゴンの日系ホテルが提供する至福のマッサージ';
        $this->data['pageDescription'] = '東屋ホテル（Azumaya Hotel）は日本人出張客におすすめのホテルです。ミャンマー・ヤンゴンで「海外出張者のための心安らぐ空間」をコンセプトにしており、「東屋」には和朝食や露天風呂など「日本」を感じさせてくれる空間があります。';
        $this->data['pageKeywords'] = '東屋ホテル,Azumaya Hotel,マッサージ,和朝食,露天風呂,日系ホテル,日本語対応,出張者向け';
        $this->data['pageImage'] = asset('customer/azumaya_massage/main.jpg');

        $this->data['stylesheets'] .=
        HTML::style('customer/azumaya_massage/azumaya_massage.css');

        $this->view_str = 'www.customer.azumaya_massage';
    }
}
