<?php
if ( !defined( '_PS_VERSION_' ) )
  exit;
 
class Slideproduct extends Module {
  public function __construct() {
    $this->name = 'slideproduct';
    $this->tab = 'front_office_features';
    $this->version = 1.0;
    $this->author = 'Tedos';
    $this->need_instance = 0;
    if (!Configuration::get('CATEGORIA'))
        $this->warning = $this->l('sin categoria');
    
    parent::__construct();

    $this->displayName = $this->l( 'Modulo slide productos' );
    $this->description = $this->l( 'modulo que muestra productos en el home.' );
    $this->confirmUninstall = $this->l('Estas seguro?');
  }
 
  public function install() {
    if(!parent::install() OR 
       !$this->registerHook('home') OR
       !Configuration::updateValue('CATEGORIA', 2))
      return false;
    return true;
  }

  public function uninstall() {
    if (!parent::uninstall() OR
        !Configuration::deleteByName('CATEGORIA'))
        return false;
    return true;
  }

  public function getContent() {
    $this->_errors = array();
    $output = '<h2>'.$this->displayName.'</h2>';
    if (Tools::isSubmit('slideproduct')) {
        $CATEGORIA = Tools::getValue('CATEGORIA');
        if ($CATEGORIA == 0)
            $this->_errors[] = $this->l('Error.');
        if (sizeof($this->_errors) == 0)
        {
            Configuration::updateValue('CATEGORIA', $CATEGORIA);
            $output .= $this->displayConf($this->l('Valores guardados'));
        }
    }
    else
        $output .= $this->displayErrors();
    return $output.$this->displayForm();
}
  public function displayForm() {
    $id_cat=Tools::getValue('CATEGORIA', Configuration::get('CATEGORIA'));
    $nombre ="n";
    $form="";
      $form.= '
      <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
          <fieldset>
              <legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Configuración').'</legend>
              <h2>'.$this->l('Categoria que aparecera en el home').'</h2>
              <label>'.$this->l('Categoria').'</label>
              <div class="margin-form">
               <select name="CATEGORIA">';
              $Category = new Category();
              $cats = $Category->getCategories( (int)(Configuration::get('PS_LANG_DEFAULT')), true, false  ) ;
              foreach ($cats as $cat){
                $form.= '<option value="'.$cat['id_category'].' ">'.$cat['name'].'</option>';
                if((int)$id_cat==(int)$cat['id_category'])$nombre = $cat['name'];
              }
              $form.= '
               </select>
                <p class="clear">Categoría actual '.$nombre.'</p>
              </div>
              <center><input type="submit" name="slideproduct" value="'.$this->l('Guardar').'" class="button" /></center>
          </fieldset>
      </form>';
      return $form;
  }
  public function displayErrors(){
    $errors =
        '<div class="error">
            <img src="../img/admin/error2.png" />
            '.sizeof($this->_errors).' '.(sizeof($this->_errors) > 1 ? $this->l('errors') : $this->l('error')).'
            <ol>';
    foreach ($this->_errors AS $error)
        $errors .= '<li>'.$error.'</li>';
    $errors .= '
            </ol>
        </div>';
    return $errors;
  }
  public function displayConf($conf){
      return
          '<div class="conf">
              <img src="../img/admin/ok2.png" /> '.$conf.'
          </div>';
  }
  public function hookHome($params) {
    global $smarty;
    $id_lang = Configuration::get('PS_LANG_DEFAULT');
    $id_cat=Tools::getValue('CATEGORIA', Configuration::get('CATEGORIA'));
    $categoria = new Category($id_cat);
    $products_all = $categoria->getProducts($id_lang,1,100);
    $smarty->assign(array(
    'path' => $this->_path,
    'products' => $products_all,
    'homeSize' => Image::getSize('home')));
    return $this->display( __FILE__, 'view/Slideproduct.tpl' );
  }
}
?>