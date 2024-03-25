<?php

namespace theme_plugin\components;

class Panel
{
    public function add_actions()
    {
        add_action('wp_footer', [$this, 'scripts']);
    }

	public function scripts() {
		?>
        <div class="sh-side-options sh-side-options-pages">
            <div class="sh-side-options-container" data-url="https://jevelin.shufflehound.com/the-new-reserch/">
                <a href="//jevelin.shufflehound.com/hello/" class="sh-side-options-item sh-accent-color">
                    <div class="sh-side-options-item-container">
                        <i class="icon icon-layers"></i>
                    </div>
                    <div class="sh-side-options-hover">
                        Showcase
                    </div>
                </a>
                <a class="sh-side-options-item sh-side-options-item-trigger-demos sh-accent-color">
                    <div class="sh-side-options-item-container">
                        <i class="icon icon-eyeglass"></i>
                    </div>
                    <div class="sh-side-options-hover">
                        Demo<span></span>viewer
                    </div>
                </a>
                <a target="blank" href="https://shufflehound.com/get/jevelin" class="sh-side-options-item sh-accent-color">
                    <div class="sh-side-options-item-container">
                        <i class="icon icon-bag"></i>
                    </div>
                    <div class="sh-side-options-hover">
                        Purchase<span></span>Jevelin
                    </div>
                </a>
                <a href="//jevelin.shufflehound.com/hello/#questions" class="sh-side-options-item sh-accent-color">
                    <div class="sh-side-options-item-container">
                        <i class="icon icon-question"></i>
                    </div>
                    <div class="sh-side-options-hover">
                        Questions<span></span>/<span></span>Answers
                    </div>
                </a>
                <a target="blank" href="https://support.shufflehound.com/" class="sh-side-options-item sh-accent-color">
                    <div class="sh-side-options-item-container">
                        <i class="icon icon-support"></i>
                    </div>
                    <div class="sh-side-options-hover">
                        Get<span></span>Support
                    </div>
                </a>
                <a target="blank" href="https://support.shufflehound.com/pre-sale-questions/" class="sh-side-options-item sh-accent-color">
                    <div class="sh-side-options-item-container">
                        <i class="icon icon-envelope"></i>
                    </div>
                    <div class="sh-side-options-hover" style="white-space: nowrap;">
                        Ask a Pre-Sale<span></span>Question
                    </div>
                </a>
            </div>
            <div class="sh-side-demos-container">
                <div class="sh-side-demos-container-close">
                    <i class="ti-close"></i>
                </div>
                <div class="sh-side-demos-intro">
                    <h3 class="sh-side-demos-intro-title sh-heading-font">
                        <img src="https://cdn.jevelin.shufflehound.com/wp-content/uploads/2016/05/Je_Logo_black_big.png" alt="">
                        Demos
                    </h3>
                    <p class="sh-side-demos-intro-descr sh-heading-font">
                        Choose one of our premium made
                        demos and make it your own!
                    </p>
                </div>
                <div class="sh-side-demos-loop">
                    <div class="sh-side-demos-loop-container">
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/burger-shop/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2020/11/burder-shop-preview.jpg" alt="digitalt-jevelin">
                                                <div class="sh-side-demos-item-tag">
                                                    new </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Burger Shop </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/business/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/12/screenshot-jevelin-business2.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Business </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/startup-clean">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/11/screenshot-jevelin-startup-clean.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Startup Clean </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/startup-creative/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/11/creative-startup.jpg" alt="digitalt-jevelin">
                                                <div class="sh-side-demos-item-tag">
                                                    new </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Startup Creative </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/creative-agency/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/03/jevelin-agency.png" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Creative Agency </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/minimal-furniture-shop/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2020/09/minimal-furniture-demo-preview.png" alt="digitalt-jevelin">
                                                <div class="sh-side-demos-item-tag">
                                                    new </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Minimal Furniture Shop </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/medical/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/02/screenshot-jevelin-medical.png" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Medical </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/mobile-app-2/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2020/07/screenshot-jevelin-app2.jpg" alt="digitalt-jevelin">
                                                <div class="sh-side-demos-item-tag">
                                                    new </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Mobile App 2 </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/education/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin-education.png" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Education </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/single-product/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/09/single-product.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Single Product </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/portfolio-freelance/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/11/portfolio-freelance.jpg" alt="digitalt-jevelin">
                                                <div class="sh-side-demos-item-tag">
                                                    new </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Portfolio Freelance </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/corporate-accounting/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/10/Demo-preview-frame.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Corporate Accounting </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/mobile-app/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/12/screenshot-jevelin-app.jpg" alt="digitalt-jevelin">
                                                <div class="sh-side-demos-item-tag">
                                                    new </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Mobile App </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/portfolio-minimalistic/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/11/minimal-portfolio.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Portfolio Minimalistic </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/architect/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/10/screenshot-jevelin-architect.jpg" alt="digitalt-jevelin">
                                                <div class="sh-side-demos-item-tag">
                                                    new </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Architect </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/portfolio-full-width/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/10/screenshot-jevelin-portfolio-full-width.jpg" alt="digitalt-jevelin">
                                                <div class="sh-side-demos-item-tag">
                                                    new </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Portfolio Full-Width </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/personal-blog/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2019/09/screenshot-jevelin-peronal-blog.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Personal Blog </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/fashion-shop/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin-ecommerce.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Fashion eCommerce </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/finances/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Finance </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/digital-media-agency/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/digitalt-jevelin.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Digital Media Agency </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/startup/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin18.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Startup </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/corporate/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin11.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Corporate </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/portfolio1/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin17.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Portfolio </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/blog1/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin16.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Blog + Sidebar </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/blog1/from-side-to-side/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin1-1.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Blog - Side to Side </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/construction/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin23.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Construction </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/blog1/masonry_sidebar/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin2-1.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Blog - Full </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/home/home-creative/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin5.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Creative </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/shop1/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin14.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Shop </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/autospot/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin1.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Autospot </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/portfolio1/masonry-side-header/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin10.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Portfolio + Side Header </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/landing/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin13.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Landing </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/landing2/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin-LANDING2.png" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Landing 2 </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/home/home-fitness/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin9.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Fitness </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/coming-soon/side-by-side/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin22.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Coming Soon - Side by Side </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/coming-soon/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin21.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Coming Soon </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/home/home-photography/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin4.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Photography </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/home/home-nature/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin3-1.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Nature </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/wedding/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin8.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Wedding </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin7.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Basic/Classic </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/boxed/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin12.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Boxed </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/home/home-event/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin6.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Event </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/foodie/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin20.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Foodie </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/beauty/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin19.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Beauty </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="https://jevelin.shufflehound.com/crypto/">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin-crypto.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Crypto </div>
                            </a>
                        </div>
                        <div class="sh-side-demos-item">
                            <a href="">
                                <div class="sh-image-lazy-loading">
                                    <div class="sh-single-image-container sh-single-image-container-lazy">
                                        <div class="ratio-container" style="padding-top: 62.692307692308%;">
                                            <div class="ratio-content">
                                                <img class="sh-image-url sh-side-demos-image" data-src="https://jevelin.shufflehound.com/wp-content/uploads/sites/22/2016/05/screenshot-jevelin-coming-soon.jpg" alt="digitalt-jevelin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sh-side-demos-item-name">
                                    Coming Soon </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<style>
            .sh-side-options {
                position: fixed;
                top: 0; bottom: 0;
                right: 0;
                z-index: 12345678902;
                transition: 0.3s all ease;
                transition: 0.2s all;
                padding: 0 0;
                width: 420px;
                transform: translateX(420px);
            }

            .sh-side-options.open {
                transform: translateX(0px);
                box-shadow: 0 0px 39px 10px rgba(0,0,0,0.2);
            }

            .sh-side-options-container {
                position: absolute;
                top: 112px; left: -75px;
                width: 60px;
                background-color: rgba(255,255,2555,1);
                border-radius: 5px;
                margin-right: 15px;
                box-shadow: -10px 0px 20px 2px rgba(0,0,0,.06);
            }

           /* .sh-side-options.sh-side-options-pages .sh-side-options-container {
                top: 150px;
            }*/

            .sh-side-options-item {
                display: block;
                text-align: center;
                margin: 0;
                transition: 0.3s all ease-in-out;
                position: relative;
                padding: 7px;
                cursor: pointer;
            }

            .sh-side-options-item:not(:last-child) {
                border-bottom: 1px solid #f1f3fc;
            }

            .sh-side-options-item-container {
                border-radius: 4px;
                padding: 8px 0;
            }

            .sh-side-options-item:hover .sh-side-options-item-container,
            .sh-side-options-item:focus .sh-side-options-item-container,
            .sh-side-options.open .sh-side-options-item-trigger-demos .sh-side-options-item-container {
                background-color: #f3f5fd;
            }

            .sh-side-options-item i {
                font-size: 22px;
            }

            .sh-side-options-item:not(:hover):not(:focus) {
                color: #9396a5!important;
            }

            .sh-side-options-item:hover .sh-side-options-hover {
                opacity: 1;
                transform: translateX(-97%);
                visibility: visible;
            }

            .sh-side-options-hover {
                position: absolute;
                background-color: #ffffff;
                color: #32343d;
                padding: 20px 26px;
                transform: translateX(-70%);
                left: 0;
                top: 0;
                bottom: 0;
                opacity: 0;
                transition: 0.2s all ease-in-out;
                z-index: -100;
                border-top-left-radius: 5px;
                border-bottom-left-radius: 5px;
                font-size: 13px;
                box-shadow: 0 0 20px 2px rgba(0,0,0,0.08);
                visibility: hidden;
            }

            .sh-side-options-hover span {
                padding: 0px 3px;
            }

            @media (max-width: 700px) {

                .sh-side-options {
                    width: 52px;
                }

                .sh-side-options-item {
                    padding: 10px 0;
                }

                .sh-side-options-item i {
                    font-size: 16px;
                }

            }

            @media (max-width: 600px) {

                .sh-side-options {
                    display: none;
                }

            }

            @media (max-height: 500px) {
                .sh-side-options {
                    top: 120px!important;
                }
            }


            .sh-side-options-item i {
                color: #9396a5!important;
            }

            .sh-side-options.open .sh-side-options-item-trigger-demos i,
            .sh-side-options-item:hover i,
            .sh-side-options-item:focus i {
                color: #294cff!important;
            }
		</style>

		<?php
	}
}