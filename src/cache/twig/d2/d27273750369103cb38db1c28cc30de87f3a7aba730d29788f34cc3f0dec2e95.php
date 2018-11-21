<?php

/* modular/hero.html.twig */
class __TwigTemplate_e3b6c8e8681bfc2b6fd55fa8cad2bda293ec7283ed3c3072268cae6964a15126 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<section id=\"body\">
  <div class=\"wrapper padding\">
    <div style=\"display: inline-block; width: 45%\">
      ";
        // line 4
        echo $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array());
        echo "
    </div>

    <div style=\"display: inline-block; width: 50%\">
      <img src=\"";
        // line 8
        echo $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "media", array()), "lion-hero.jpg", array(), "array"), "url", array());
        echo "\" style=\"width:100%\" >
    </div>
  </div>
</section>";
    }

    public function getTemplateName()
    {
        return "modular/hero.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 8,  24 => 4,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<section id=\"body\">
  <div class=\"wrapper padding\">
    <div style=\"display: inline-block; width: 45%\">
      {{ page.content }}
    </div>

    <div style=\"display: inline-block; width: 50%\">
      <img src=\"{{ page.media['lion-hero.jpg'].url }}\" style=\"width:100%\" >
    </div>
  </div>
</section>", "modular/hero.html.twig", "/var/www/grav-admin/user/themes/custom-cave/templates/modular/hero.html.twig");
    }
}
