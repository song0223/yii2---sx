<?php
namespace common\widgets;

use Yii;
use \common\widgets\Alert;


class AutoDelayAlert extends Alert
{
    /**
     * 自带的alert不支持自动消失 所以自己加个slideUp的效果
     *
     */

    public $delay = '';//消失时间

    public function init()
    {

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array) $data;
                foreach ($data as $i => $message) {
                    /* initialize css class for each alert box */
                    $this->options['class'] = $this->alertTypes[$type] . $appendCss;

                    /* assign unique id to each alert box */
                    $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;

                    echo \yii\bootstrap\Alert::widget([
                        'body' => $message,
                        'closeButton' => $this->closeButton,
                        'options' => $this->options,
                    ]);
                    $this->registerAssets();
                }

                $session->removeFlash($type);
            }
        }
    }


    /**
     * 设置自动消失时间
     */
    protected function registerAssets()
    {
        $view = $this->getView();

        if ($this->delay > 0) {
            $js = 'jQuery("#' . $this->options['id'] . '").fadeTo(' . $this->delay . ', 0.5, function() {
				$(this).slideUp("normal", function() {
					$(this).remove();
				});
			});';
            $view->registerJs($js);
        }
    }
}
