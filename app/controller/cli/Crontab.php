<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Crontab extends CrontabController {

  public function backupDb() {
    $this->crontab->title = '每天晚上 2 點執行，備份資料庫';

    $backup = \M\Backup::create(['file' => '', 'size' => 0, 'type' => \M\Backup::TYPE_DB, 'status' => \M\Backup::STATUS_FAILURE, 'isRead' => \M\Backup::IS_READ_NO,]);
    $backup || gg('資料庫建立失敗！');

    Load::sysFunc('file.php');
    Load::sysFunc('dir.php');

    $models = array_filter(dirMap(PATH_MODEL, 1), function($t) { return pathinfo($t, PATHINFO_EXTENSION) === 'php'; });
    $models = array_map(function($m) { return pathinfo($m, PATHINFO_FILENAME); }, $models);
    $models = array_filter($models, function($m) { return class_exists("\\M\\" . $m); });
    $models = array_combine($models, array_map(function($m) { $m = "\\M\\" . $m; return array_map('\M\toArray', $m::all()); }, $models));
    fileWrite($path = PATH_TMP . 'backup_' . \M\Backup::TYPE_DB . '_' . date ('YmdHis') . '.json', json_encode($models)) || gg('寫入檔案失敗！');

    $backup->size = filesize($path);

    $backup->file->put($path) || gg('上傳檔案失敗！');

    $backup->status = \M\Backup::STATUS_SUCCESS;
    $backup->isRead = \M\Backup::IS_READ_YES;
    $backup->save() || gg('更新資料庫失敗！');
  }

  public function backupLogs() {
    $this->crontab->title = '每天晚上 3 點執行，備份 Log';

    $beforeDay = Router::params('beforeDay');
    $beforeDay !== null || $beforeDay = 1;
    $beforeDay = date('Y-m-d', strtotime(date('Y-m-d') . '-' . $beforeDay . 'day'));

    Load::sysFunc('file.php');
    foreach (['info', 'error', 'warning', 'model', 'uploader', 'saveTool', 'thumbnail', 'benchmark', 'query'] as $log) {
      if (!$backup = \M\Backup::create(['file' => '', 'size' => 0, 'type' => $log, 'status' => \M\Backup::STATUS_FAILURE, 'isRead' => \M\Backup::IS_READ_NO,]))
        continue;

      if (!file_exists($path = PATH_LOG . $log . DIRECTORY_SEPARATOR . $beforeDay . Log::EXT)) {
        $backup->status = \M\Backup::STATUS_SUCCESS;
        $backup->isRead = \M\Backup::IS_READ_YES;
        $backup->save();
        continue;
      }

      if (!is_readable($path = PATH_LOG . $log . DIRECTORY_SEPARATOR . $beforeDay . Log::EXT))
        continue;
 
      if (!fileWrite($path2 = PATH_TMP . 'backup_' . $log . '_' . date ('YmdHis') . Log::EXT, preg_replace('#\\x1b[[][^A-Za-z]*[A-Za-z]#', '', pack('H*','EFBBBF') . fileRead($path))))
        continue;

      if (!$backup->file->put($path2))
        continue;

      $backup->size = filesize($path);

      $backup->status = \M\Backup::STATUS_SUCCESS;
      $backup->isRead = \M\Backup::IS_READ_YES;
      $backup->save();

      @unlink($path);
    }
  }
}
