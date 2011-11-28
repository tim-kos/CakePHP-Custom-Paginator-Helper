<?php
class MyPaginatorHelper extends PaginatorHelper {
  public function numbers($options = array()) {
    if ($options === true) {
      $options = array(
        'before' => ' | ', 'after' => ' | ',
        'first' => 'first', 'last' => 'last',
      );
    }

    $options = am(
      array(
        'tag' => 'span',
        'before'=> null, 'after'=> null,
        'model' => $this->defaultModel(),
        'modulus' => '8', 'separator' => ' | ',
        'first' => null, 'last' => null,
        'fold' => 0, 'foldSep' => ' ... '
      ),
    (array) $options);

    $params = array_merge(array('page'=> 1), (array)$this->params($options['model']));

    unset($options['model']);

    if ($params['pageCount'] <= 1) {
      return false;
    }

    extract($options);
    unset(
      $options['tag'], $options['before'], $options['after'], $options['model'],
      $options['modulus'], $options['separator'], $options['first'], $options['last'], $options['foldSep'], $options['fold']
    );

    $out = '';

    if ($modulus && $params['pageCount'] > $modulus) {
      $half = intval($modulus / 2);

      $end = $params['page'] + $half;
      if ($end > $params['pageCount']) {
        $end = $params['pageCount'];
      }

      $start = $end - $modulus;
      if ($start <= 1) {
        $start = 1;
        $end = $params['page'] + ($modulus  - $params['page']) + 1;
      }

      if ($first && $start > (int)$first) {
        if ($start == $first + 1) {
          $out .= $this->first($first, array('tag' => $tag, 'after' => $separator));
        } else {
          $out .= $this->first($first, array('tag' => $tag));
        }
      }

      $out .= $before;

      if ($start - 1 > $fold) {
        for ($i = 1; $i < $fold + 1; $i++) {
          $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options));
        }
        $out .= $this->Html->tag('span', $foldSep, array('class' => 'foldSep'));
      }

      for ($i = $start; $i < $params['page']; $i++) {
        $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options)) . $separator;
      }

      $out .= $this->Html->tag($tag, $params['page'], array('class' => 'current'));
      if ($i != $params['pageCount']) {
        $out .= $separator;
      }

      $start = $params['page'] + 1;
      for ($i = $start; $i < $end; $i++) {
        $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options)). $separator;
      }

      if ($end != $params['page']) {
        $out .= $this->Html->tag($tag, $this->link($i, array('page' => $end), $options));
      }

      if ($end < $params['pageCount'] - $fold) {
        $out .= $this->Html->tag('span', $foldSep, array('class' => 'foldSep'));
        for ($i = $params['pageCount'] - $fold + 1; $i < $params['pageCount'] + 1; $i++) {
          $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options));
        }
      }

      $out .= $after;

      if ($last && $end <= $params['pageCount'] - (int)$last) {
        if ($end + 1 == $params['pageCount']) {
          $out .= $this->last($last, array('tag' => $tag, 'before' => $separator));
        } else {
          $out .= $this->last($last, array('tag' => $tag));
        }
      }

      return $this->output($out);
    }

    $out .= $before;
    for ($i = 1; $i <= $params['pageCount']; $i++) {
      if ($i == $params['page']) {
        $out .= $this->Html->tag($tag, $i, array('class' => 'current'));
      } else {
        $out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options));
      }
      if ($i != $params['pageCount']) {
        $out .= $separator;
      }
    }
    $out .= $after;

    return $this->output($out);
  }

/**
 * Returns a title for use on paginated pages, depending on the page
 *
 * @param string $title
 * @param integer $page
 * @param mixed $requirement
 * @param mixed $alternateTitle
 * @return string
 */
  function myPageTitle($title = null, $page = 0, $requirement = true, $alternateTitle = false) {
    if (!empty($requirement) && $page !== 0) {
      return $title . ' : Page ' . $page;
    }
    if ($alternateTitle && $page !== 0) {
      return $alternateTitle . ' : Page ' . $page;
    }
    return $title;
  }
}
?>