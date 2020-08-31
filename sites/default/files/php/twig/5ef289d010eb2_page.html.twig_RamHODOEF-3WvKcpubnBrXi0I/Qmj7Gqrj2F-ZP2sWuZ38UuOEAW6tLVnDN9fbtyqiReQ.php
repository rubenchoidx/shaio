<?php

/* themes/bootstrap/templates/system/page.html.twig */
class __TwigTemplate_b4dc9352cffb2ec7d6ab95902673e423b4afc8e5de39477bd30d2c72ec08934f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'sliderhome' => array($this, 'block_sliderhome'),
            'menuprincipalhome' => array($this, 'block_menuprincipalhome'),
            'menusectionscontainer' => array($this, 'block_menusectionscontainer'),
            'main' => array($this, 'block_main'),
            'header' => array($this, 'block_header'),
            'sidebar_first' => array($this, 'block_sidebar_first'),
            'highlighted' => array($this, 'block_highlighted'),
            'help' => array($this, 'block_help'),
            'content' => array($this, 'block_content'),
            'sidebar_second' => array($this, 'block_sidebar_second'),
            'videoservicios' => array($this, 'block_videoservicios'),
            'eventos' => array($this, 'block_eventos'),
            'slideracerca' => array($this, 'block_slideracerca'),
            'contentempleados' => array($this, 'block_contentempleados'),
            'footer' => array($this, 'block_footer'),
            'footer_derechos' => array($this, 'block_footer_derechos'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array("set" => 54, "if" => 155, "block" => 156);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('set', 'if', 'block'),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 54
        echo "  ";
        $context["container"] = (($this->getAttribute($this->getAttribute(($context["theme"] ?? null), "settings", array()), "fluid_container", array())) ? ("container-fluid") : ("container"));
        // line 55
        echo "  ";
        // line 56
        echo "  
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-68019512-1\"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
  
    gtag('config', 'UA-68019512-1');
  </script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  
  <div class=\"header-page\">
      <nav class=\"navbar navbar-default navbar-fixed-top\">
          <div class=\"container-fluid\">
  
          
  
                      <div class=\"nav_sup\">       
                         <ul class=\"menu-sup\">
                           <li><a href=\"/\"></a></li>
                           <li><a href=\"/contacto\">Contacto</a></li>
                           <li><a href=\"/como-llegar\">Cómo llegar</a></li>
                           <li><a href=\"/blog-vital\">Blog Vital</a></li>
                           <!--<li><a href=\"/corazon_saludable_site\">Corazón Saludable</a></li>-->
                           <li><a href=\"tel:+5715938210\">PBX: (+ 57 1) 593 82 10</a></li>
                           <li><a href=\"https://sgi.almeraim.com/sgi/secciones/tramites/diligenciarTramite.php?instance=2c8ca82ba983d58e9555e1248770c53b&tipoId=1&token=3395601237d206b591171b3580d54ace\" target=\"_blank\">PQR</a></li>
                           <li><a href=\"https://www.psepagos.co/PSEHostingUI/ShowTicketOffice.aspx?ID=7441\" target=\"Blank\"><img src=\"/sites/default/files/2019-06/logo_pse.png\" width=\"30px\"></a></li> 
                         </ul>
                          <div class=\"buscar\">
                              <div class=\"ui search\">
                                <!-- <span><a href=\"/user/register\"><img src=\"/sites/default/files/iconos_r1_c3.jpg\"></a></span>-->
                                <!-- <span><a data-toggle=\"collapse\" href=\"#collapseExample\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapseExample\"><img src=\"/sites/default/files/cambiardeidiomabandera.png\" width=\"40px\"></a></span> -->
                                <span style=\"    top: 7%;
                                position: fixed;
                                float: right;
                                right: 1%;
                            \"><!--efecto nueno -->
                                  <!-- <div class=\"collapse\" id=\"collapseExample\"> -->
                                      <div class=\"card card-body\">
                                        <a href=\"javascript:doGTranslate('es|es')\"><img src=\"/sites/default/files/2019-03/ES_Shaio.png\" width=\"40px\"> </a> 
                                        <a  href=\"javascript:doGTranslate('es|en')\"> <img src=\"/sites/default/files/2019-03/EN_Shaio.png\" width=\"40px\"></a>
                                      </div>
                                  <!-- </div> -->
                                   <!-- fin efecto nuevo --></span>
                                <div id=\"form-buscar\">";
        // line 101
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "buscador", array()), "html", null, true));
        echo "</div> 
                                <span id=\"icono-buscar\"><img src=\"/sites/default/files/iconos_r1_c1.jpg\"></span>
                              </div>    
                          </div>
                      </div>
                      <div class=\"traductor-movil\">
                          <a href=\"javascript:doGTranslate('es|es')\"><img src=\"https://www.shaio.org/sites/default/files/2019-03/ES_Shaio.png\" width=\"40px\"> </a> 
                           <a  href=\"javascript:doGTranslate('es|en')\"> <img src=\"https://www.shaio.org/sites/default/files/2019-03/EN_Shaio.png\" width=\"40px\"></a>
                           <!-- buscador movil -->
                           <div class=\"buscar\">
                            <div class=\"ui search\">
                              <div id=\"form-buscar buscador-movil\">";
        // line 112
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "buscador", array()), "html", null, true));
        echo "</div> 
                              <span id=\"icono-buscar\"><img src=\"/sites/default/files/iconos_r1_c1.jpg\"></span>
                            </div>    
                          </div>
                           <!-- fin buscador movil -->
                      </div> 
                      <!-- Brand and toggle get grouped for better mobile display -->
                        <div class=\"navbar-header\">
                           <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\" aria-expanded=\"false\">
                             <span class=\"sr-only\">Toggle navigation</span>
                             <span class=\"icon-bar\"></span>
                             <span class=\"icon-bar\"></span>
                             <span class=\"icon-bar\"></span>
                           </button>
                           <a class=\"navbar-brand\" href=\"#\">
                              ";
        // line 127
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "logomarca", array()), "html", null, true));
        echo "
                           </a>
                        </div>
                        <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
                            <div class=\"nav\" id=\"menu-shaio\">
                                ";
        // line 132
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "menuencabezado", array()), "html", null, true));
        echo "
                                <!-- Menu Top responsive -->
                                   <ul class=\"menu-sup-movil\">
                                   <li><a href=\"/contacto\">Contacto</a></li>  
                                   <li><a href=\"/blog-vital\">Blog Vital</a></li>
                                    <li><a href=\"/como-llegar\">Cómo llegar</a></li>
                                    <li><a href=\"https://sgi.almeraim.com/sgi/secciones/tramites/diligenciarTramite.php?instance=2c8ca82ba983d58e9555e1248770c53b&tipoId=1&token=3395601237d206b591171b3580d54ace\" target=\"_blank\">PQR</a></li> 
                                    <li><a href=\"tel:+5717423330\">PBX: +(571) 593 82 10</a></li>
                                    <li><a href=\"https://www.psepagos.co/PSEHostingUI/ShowTicketOffice.aspx?ID=7441\" target=\"blank\">Pagos PSE</a></li>
                                    <li><a href=\"tel:+0315938210\">¿Tiene preguntas? +(571) 593 8210</a></li>
                                    <li><a href=\"tel:+0317423330\">¿Necesita una cita? +(571) 742 33 30</a></li>
                                  </ul>
                                     
                                <!-- fin menu top responsive -->
                            </div>
                        </div>
          </div>
      </nav>
  </div>
  
  <div class=\"body-site\">
                ";
        // line 154
        echo "  
                ";
        // line 155
        if ($this->getAttribute(($context["page"] ?? null), "sliderhome", array())) {
            // line 156
            echo "                  ";
            $this->displayBlock('sliderhome', $context, $blocks);
            // line 161
            echo "                ";
        }
        // line 162
        echo "  
  
                ";
        // line 164
        if ($this->getAttribute(($context["page"] ?? null), "menuprincipalhome", array())) {
            // line 165
            echo "                  ";
            $this->displayBlock('menuprincipalhome', $context, $blocks);
            // line 171
            echo "                ";
        }
        // line 172
        echo "  
                 ";
        // line 173
        if ($this->getAttribute(($context["page"] ?? null), "menusectionscontainer", array())) {
            // line 174
            echo "                    ";
            $this->displayBlock('menusectionscontainer', $context, $blocks);
            // line 182
            echo "                ";
        }
        // line 183
        echo "  
  
                ";
        // line 186
        echo "                ";
        $this->displayBlock('main', $context, $blocks);
        // line 257
        echo "  
                ";
        // line 258
        if ($this->getAttribute(($context["page"] ?? null), "videoservicios", array())) {
            // line 259
            echo "                  ";
            $this->displayBlock('videoservicios', $context, $blocks);
            // line 264
            echo "                ";
        }
        // line 265
        echo "  
                ";
        // line 266
        if ($this->getAttribute(($context["page"] ?? null), "eventos", array())) {
            // line 267
            echo "                  ";
            $this->displayBlock('eventos', $context, $blocks);
            // line 272
            echo "                ";
        }
        // line 273
        echo "  
                ";
        // line 274
        if ($this->getAttribute(($context["page"] ?? null), "slideracerca", array())) {
            // line 275
            echo "                  ";
            $this->displayBlock('slideracerca', $context, $blocks);
            // line 280
            echo "                ";
        }
        // line 281
        echo "  
                ";
        // line 282
        if ($this->getAttribute(($context["page"] ?? null), "contentempleados", array())) {
            // line 283
            echo "                  ";
            $this->displayBlock('contentempleados', $context, $blocks);
            // line 288
            echo "                ";
        }
        // line 289
        echo "  
                ";
        // line 290
        if ($this->getAttribute(($context["page"] ?? null), "footer", array())) {
            // line 291
            echo "                  ";
            $this->displayBlock('footer', $context, $blocks);
            // line 296
            echo "                ";
        }
        // line 297
        echo "  
                ";
        // line 298
        if ($this->getAttribute(($context["page"] ?? null), "footer_derechos", array())) {
            // line 299
            echo "                  ";
            $this->displayBlock('footer_derechos', $context, $blocks);
            // line 304
            echo "                ";
        }
        // line 305
        echo "  
  
  </div>
  ";
    }

    // line 156
    public function block_sliderhome($context, array $blocks = array())
    {
        // line 157
        echo "                    <div id=\"slider-home\" class=\"slider-home\">
                      ";
        // line 158
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "sliderhome", array()), "html", null, true));
        echo "
                    </div>
                    ";
    }

    // line 165
    public function block_menuprincipalhome($context, array $blocks = array())
    {
        // line 166
        echo "                      <div id=\"menuprincipalhome-home\" class=\"menuprincipalhome-home\">
                        ";
        // line 167
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "menuprincipalhome", array()), "html", null, true));
        echo "
                        ";
        // line 168
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "menuprincipalespacio", array()), "html", null, true));
        echo "
                      </div>                     
                    ";
    }

    // line 174
    public function block_menusectionscontainer($context, array $blocks = array())
    {
        // line 175
        echo "                      <div id=\"menusectionscontainer-home\" class=\"menusectionscontainer-home\">
                        ";
        // line 176
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "menusectionscontainer", array()), "html", null, true));
        echo "
                      </div>
                      <div class=\"espacio-menusectionscontainer\">
                        <h2><br></h2>
                      </div>
                    ";
    }

    // line 186
    public function block_main($context, array $blocks = array())
    {
        // line 187
        echo "                  <div role=\"main\" class=\"main-container ";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["container"] ?? null), "html", null, true));
        echo " js-quickedit-main-content\">
                    <div class=\"row\">
  
                      ";
        // line 191
        echo "                      ";
        if ($this->getAttribute(($context["page"] ?? null), "header", array())) {
            // line 192
            echo "                        ";
            $this->displayBlock('header', $context, $blocks);
            // line 199
            echo "                      ";
        }
        // line 200
        echo "  
                      ";
        // line 202
        echo "                      ";
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_first", array())) {
            // line 203
            echo "                        ";
            $this->displayBlock('sidebar_first', $context, $blocks);
            // line 208
            echo "                      ";
        }
        // line 209
        echo "  
                      ";
        // line 211
        echo "                      ";
        // line 212
        $context["content_classes"] = array(0 => ((($this->getAttribute(        // line 213
($context["page"] ?? null), "sidebar_first", array()) && $this->getAttribute(($context["page"] ?? null), "sidebar_second", array()))) ? ("col-sm-6") : ("")), 1 => ((($this->getAttribute(        // line 214
($context["page"] ?? null), "sidebar_first", array()) && twig_test_empty($this->getAttribute(($context["page"] ?? null), "sidebar_second", array())))) ? ("col-sm-9") : ("")), 2 => ((($this->getAttribute(        // line 215
($context["page"] ?? null), "sidebar_second", array()) && twig_test_empty($this->getAttribute(($context["page"] ?? null), "sidebar_first", array())))) ? ("col-sm-9") : ("")), 3 => (((twig_test_empty($this->getAttribute(        // line 216
($context["page"] ?? null), "sidebar_first", array())) && twig_test_empty($this->getAttribute(($context["page"] ?? null), "sidebar_second", array())))) ? ("col-sm-12") : ("")));
        // line 219
        echo "                      <section";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["content_attributes"] ?? null), "addClass", array(0 => ($context["content_classes"] ?? null)), "method"), "html", null, true));
        echo ">
  
                        ";
        // line 222
        echo "                        ";
        if ($this->getAttribute(($context["page"] ?? null), "highlighted", array())) {
            // line 223
            echo "                          ";
            $this->displayBlock('highlighted', $context, $blocks);
            // line 226
            echo "                        ";
        }
        // line 227
        echo "  
                        ";
        // line 229
        echo "                        ";
        if ($this->getAttribute(($context["page"] ?? null), "help", array())) {
            // line 230
            echo "                          ";
            $this->displayBlock('help', $context, $blocks);
            // line 233
            echo "                        ";
        }
        // line 234
        echo "  
                        ";
        // line 236
        echo "                        ";
        $this->displayBlock('content', $context, $blocks);
        // line 240
        echo "                      </section>
  
  
  
                      
  
                      ";
        // line 247
        echo "                      ";
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_second", array())) {
            // line 248
            echo "                        ";
            $this->displayBlock('sidebar_second', $context, $blocks);
            // line 253
            echo "                      ";
        }
        // line 254
        echo "                    </div>
                  </div>
                ";
    }

    // line 192
    public function block_header($context, array $blocks = array())
    {
        // line 193
        echo "                          ";
        if ( !($context["is_front"] ?? null)) {
            // line 194
            echo "                              <div class=\"col-sm-12\" role=\"heading\">
                                ";
            // line 195
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "header", array()), "html", null, true));
            echo "
                              </div>
                          ";
        }
        // line 198
        echo "                        ";
    }

    // line 203
    public function block_sidebar_first($context, array $blocks = array())
    {
        // line 204
        echo "                          <aside class=\"col-sm-3\" role=\"complementary\">
                            ";
        // line 205
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "sidebar_first", array()), "html", null, true));
        echo "
                          </aside>
                        ";
    }

    // line 223
    public function block_highlighted($context, array $blocks = array())
    {
        // line 224
        echo "                            <div class=\"highlighted\">";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "highlighted", array()), "html", null, true));
        echo "</div>
                          ";
    }

    // line 230
    public function block_help($context, array $blocks = array())
    {
        // line 231
        echo "                            ";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "help", array()), "html", null, true));
        echo "
                          ";
    }

    // line 236
    public function block_content($context, array $blocks = array())
    {
        // line 237
        echo "                          <a id=\"main-content\"></a>
                          ";
        // line 238
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "content", array()), "html", null, true));
        echo "
                        ";
    }

    // line 248
    public function block_sidebar_second($context, array $blocks = array())
    {
        // line 249
        echo "                          <aside class=\"col-sm-3\" role=\"complementary\">
                            ";
        // line 250
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "sidebar_second", array()), "html", null, true));
        echo "
                          </aside>
                        ";
    }

    // line 259
    public function block_videoservicios($context, array $blocks = array())
    {
        // line 260
        echo "                      <div id=\"videoservicios\" class=\"videoservicios\">
                        ";
        // line 261
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "videoservicios", array()), "html", null, true));
        echo "
                      </div>                     
                    ";
    }

    // line 267
    public function block_eventos($context, array $blocks = array())
    {
        // line 268
        echo "                    <div id=\"eventos-home\" class=\"eventos-home\">
                            ";
        // line 269
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "eventos", array()), "html", null, true));
        echo "
                    </div>
                  ";
    }

    // line 275
    public function block_slideracerca($context, array $blocks = array())
    {
        // line 276
        echo "                    <div id=\"slideracerca\" class=\"slideracerca\">
                            ";
        // line 277
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "slideracerca", array()), "html", null, true));
        echo "
                    </div>
                  ";
    }

    // line 283
    public function block_contentempleados($context, array $blocks = array())
    {
        // line 284
        echo "                    <div class=\"content_empleados\" role=\"contentinfo\">
                      ";
        // line 285
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "contentempleados", array()), "html", null, true));
        echo "
                    </div>
                  ";
    }

    // line 291
    public function block_footer($context, array $blocks = array())
    {
        // line 292
        echo "                    <footer class=\"footer ";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["container"] ?? null), "html", null, true));
        echo "\" role=\"contentinfo\">
                      ";
        // line 293
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "footer", array()), "html", null, true));
        echo "
                    </footer>
                  ";
    }

    // line 299
    public function block_footer_derechos($context, array $blocks = array())
    {
        // line 300
        echo "                    <div class=\"footer_derechos\" role=\"contentinfo\">
                      ";
        // line 301
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "footer_derechos", array()), "html", null, true));
        echo "
                    </div>
                  ";
    }

    public function getTemplateName()
    {
        return "themes/bootstrap/templates/system/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  583 => 301,  580 => 300,  577 => 299,  570 => 293,  565 => 292,  562 => 291,  555 => 285,  552 => 284,  549 => 283,  542 => 277,  539 => 276,  536 => 275,  529 => 269,  526 => 268,  523 => 267,  516 => 261,  513 => 260,  510 => 259,  503 => 250,  500 => 249,  497 => 248,  491 => 238,  488 => 237,  485 => 236,  478 => 231,  475 => 230,  468 => 224,  465 => 223,  458 => 205,  455 => 204,  452 => 203,  448 => 198,  442 => 195,  439 => 194,  436 => 193,  433 => 192,  427 => 254,  424 => 253,  421 => 248,  418 => 247,  410 => 240,  407 => 236,  404 => 234,  401 => 233,  398 => 230,  395 => 229,  392 => 227,  389 => 226,  386 => 223,  383 => 222,  377 => 219,  375 => 216,  374 => 215,  373 => 214,  372 => 213,  371 => 212,  369 => 211,  366 => 209,  363 => 208,  360 => 203,  357 => 202,  354 => 200,  351 => 199,  348 => 192,  345 => 191,  338 => 187,  335 => 186,  325 => 176,  322 => 175,  319 => 174,  312 => 168,  308 => 167,  305 => 166,  302 => 165,  295 => 158,  292 => 157,  289 => 156,  282 => 305,  279 => 304,  276 => 299,  274 => 298,  271 => 297,  268 => 296,  265 => 291,  263 => 290,  260 => 289,  257 => 288,  254 => 283,  252 => 282,  249 => 281,  246 => 280,  243 => 275,  241 => 274,  238 => 273,  235 => 272,  232 => 267,  230 => 266,  227 => 265,  224 => 264,  221 => 259,  219 => 258,  216 => 257,  213 => 186,  209 => 183,  206 => 182,  203 => 174,  201 => 173,  198 => 172,  195 => 171,  192 => 165,  190 => 164,  186 => 162,  183 => 161,  180 => 156,  178 => 155,  175 => 154,  151 => 132,  143 => 127,  125 => 112,  111 => 101,  64 => 56,  62 => 55,  59 => 54,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/bootstrap/templates/system/page.html.twig", "/Applications/MAMP/htdocs/shaio/themes/bootstrap/templates/system/page.html.twig");
    }
}
