<?php

namespace Drupal\itunes_rss\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\views\Plugin\views\style\Rss;

/**
 * Default style plugin to render an RSS feed.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "itunes_rss",
 *   title = @Translation("iTunes RSS Feed"),
 *   help = @Translation("Generates an iTunes RSS feed from a view."),
 *   theme = "views_view_itunes_rss",
 *   display_types = {"feed"}
 * )
 */
class ItunesRss extends Rss {

  /**
   * Get a list of all itunes:* fields that apply to the <channel> element.
   *
   * @return array
   *   A flat array of field names.
   *
   * @see https://help.apple.com/itc/podcasts_connect/#/itcb54353390
   */
  public function getItunesChannelFields() {
    $fields = [
      'type',
      'owner',
      'author',
      'subtitle',
      'summary',
      'explicit',
      'copyright',
      'block',
      'complete',
      'image',
      'new-feed-url',
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['image'] = ['default' => ''];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['help']['#markup'] = $this->t(
      'See @link for detailed information on available iTunes tags.',
      ['@link' => 'https://help.apple.com/itc/podcasts_connect/#/itcb54353390']
    );
    $form['image'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RSS image URL.'),
      '#default_value' => $this->options['image'],
      '#description' => $this->t('This will appear in the RSS feed itself.'),
      '#maxlength' => 1024,
    ];
    $form['category'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Category'),
      '#default_value' => $this->options['category'],
      '#description' => $this->t('This will appear in the RSS feed itself.'),
      '#maxlength' => 1024,
    ];
    $form['sub_category'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sub Category'),
      '#default_value' => $this->options['sub_category'],
      '#description' => $this->t('This will appear in the RSS feed itself.'),
      '#maxlength' => 1024,
    ];
  }

  /**
   * Get RSS feed image.
   *
   * @return string
   *   The string containing the image URL.
   */
  public function getImage() {
    $image = $this->options['image'];

    return $image;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $this->namespaces = [
      'xmlns:itunes' => 'http://www.itunes.com/dtds/podcast-1.0.dtd',
      'version' => '2.0',
    ];

    return $build;
  }
}
