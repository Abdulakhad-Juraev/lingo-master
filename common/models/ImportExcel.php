<?php


namespace common\models;


use common\modules\testmanager\models\Option;
use common\modules\testmanager\models\Question;
use common\modules\university\models\Course;
use common\modules\university\models\Direction;
use common\modules\university\models\Language;
use common\modules\university\models\Semester;
use Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * Class Import Excel
 * @package backend\modules\productmanager\models
 * @property int $category_id [int(11)]
 * @property string $file [int(11)]
 */
class ImportExcel extends Model
{
    public $file;
    private $batchSize = 100;
    private $courseMap = [];
    private $directionMap = [];
    private $semesterMap = [];
    private $languageMap = [];
    private $sexMap = [];
    private $educationalTypeMap = [];
    private $educationalFormMap = [];
    private $existingUsers = [];

    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'extensions' => 'xlsx,xls']
        ];
    }


    public function attributeLabels()
    {
        return [

            'file' => Yii::t('app', 'Faylni tanlang')

        ];
    }

    /**
     * @throws Exception
     */
    public function getImportFromExcel($file, $fileType, $id): array
    {
        set_time_limit(0);

        // Initialize reader based on file type
        if ($fileType == 'xlsx') {
            $reader = new Xlsx();
        } elseif ($fileType == 'xls') {
            $reader = new Xls();
        } else {
            throw new Exception('Invalid file type');
        }

        $errors = [];
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheetData as $key => $row) {
            if ($key == 1) { // Skip the header row
                continue;
            }
            $question = $row['B'] ?? '';
            $options = [
                1 => $row['C'] ?? '',
                2 => $row['D'] ?? '',
                3 => $row['E'] ?? '',
                4 => $row['F'] ?? ''
            ];

            if ($question && $options[1]) { // Ensure there is a question and at least one option
                $new_question = new Question();
                $new_question->title = $question;
                $new_question->test_id = $id;
                $new_question->status = Question::STATUS_ACTIVE;
                $new_question->save();

                foreach ($options as $index => $optionText) {
                    if (!empty($optionText)) {
                        $option = new Option();
                        $option->question_id = $new_question->id;
                        $option->text = $optionText;
                        $option->is_answer = ($index === 1) ? 1 : 0; // Set first option as correct
                        if (!$option->save()) {
                            $errors[] = [
                                'number' => $key,
                                'question' => $question,
                                'option_1' => $options[1],
                                'option_2' => $options[2],
                                'option_3' => $options[3],
                                'option_4' => $options[4]
                            ];
                        }
                    }
                }
            } else {
                $errors[] = [
                    'number' => $key,
                    'question' => $question,
                    'option_1' => $options[1],
                    'option_2' => $options[2],
                    'option_3' => $options[3],
                    'option_4' => $options[4]
                ];
            }
        }

        return $errors;
    }

    public function processExcel($file, $fileType, $action): array
    {
        set_time_limit(0); // Use with caution

        // Load file
        $spreadsheet = $this->loadFile($file, $fileType);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Preload necessary data
        $this->preloadData();


        // Process rows
        $errors = [];
        $rowCount = 0;
        $userUpdates = [];
        $userInserts = [];

        foreach ($sheetData as $key => $row) {
            if ($key == 1) continue; // Skip header

            $rowCount++;
            $result = $this->processRow($row, $action);

            if ($result['success']) {
                if ($action == 'import') {
                    $userInserts[] = $result['data'];
                } else {

                    $userUpdates[] = $result['data'];
                }
            } else {
                if ($result['errors']){
                    $errors[] = $result['errors'];

                }
            }

            if ($rowCount % $this->batchSize == 0) {
                $this->batchSave($userInserts, $userUpdates, $action);
                $userInserts = [];
                $userUpdates = [];
            }
        }

        $this->batchSave($userInserts, $userUpdates, $action);
        return $errors;
    }

    private function loadFile($file, $fileType)
    {
        if ($fileType == 'xlsx') {
            $reader = new Xlsx();
        } elseif ($fileType == 'xls') {
            $reader = new Xls();
        } else {
            throw new Exception('Unsupported file type');
        }
        return $reader->load($file);
    }

    private function preloadData(): void
    {
        $this->courseMap = $this->createMap(Course::find()->andWhere(['status' => Course::STATUS_ACTIVE])->all(), 'name_uz');
        $this->directionMap = $this->createMap(Direction::find()->andWhere(['status' => Direction::STATUS_ACTIVE])->all(), 'name_uz');
        $this->semesterMap = $this->createMap(Semester::find()->andWhere(['status' => Semester::STATUS_ACTIVE])->all(), 'name_uz');
        $this->languageMap = $this->createMap(Language::find()->andWhere(['status' => Language::STATUS_ACTIVE])->all(), 'name_uz');
        $this->sexMap = $this->createMapValueKey(User::sexTypesUz());
        $this->existingUsers = User::find()->select(['id', 'jshshir'])->andWhere(['type_id' => User::TYPE_ID_STUDENT])->indexBy('jshshir')->column();
        $this->educationalTypeMap = $this->createMapValueKey(User::educationalTypesUz());
        $this->educationalFormMap = $this->createMapValueKey(User::educationalFormUz());
    }

    private function createMap($data, $attribute = null): array
    {
        $map = [];
        foreach ($data as $key => $item) {
            $key = $attribute ? $this->cleanString($item->$attribute) : $this->cleanString($key);
            $map[$key] = $item;
        }
        return $map;
    }

    private function createMapValueKey($data, $attribute = null): array
    {
        $map = [];
        foreach ($data as $key => $item) {
            $key = $attribute ? $this->cleanString($item->$attribute) : $this->cleanString($key);
            $map[$item] = $key;
        }
        return $map;
    }

    private function processRow($row, $action)
    {
        $result = ['success' => true, 'errors' => [], 'data' => []];
        $jshshir = $row['D'] ?? '';
        $course = $this->courseMap[$this->cleanString($row['E'])] ?? null;
        $direction = $this->directionMap[$this->cleanString($row['G'])] ?? null;
        $language = $this->languageMap[$this->cleanString($row['F'])] ?? null;
        $educationalType = $this->educationalTypeMap[$this->cleanString($row['H'])] ?? null;
        $educationalForm = $this->educationalFormMap[$this->cleanString($row['I'])] ?? null;
        $sex = $this->sexMap[$this->cleanString($row['B'])] ?? null;
        $user_id = $this->existingUsers[$this->cleanString($jshshir)] ?? null;
        if ($action != 'import') {
            $data = [
                'id' => $user_id,
                'full_name' => $row['A'] ?? '',
                'sex' => $sex,
                'born_date' => $row['C'] ?? '',
                'jshshir' => $jshshir,
                'course_id' => $course ? $course->id : null,
                'language_id' => $language ? $language->id : null,
                'direction_id' => $direction ? $direction->id : null,
                'faculty_id' => $direction ? $direction->faculty_id : null,
                'educational_type' => $educationalType,
                'educational_form' => $educationalForm,
                'username' => $jshshir,
                'simple_password' => $jshshir,
                'created_at' => time(),
                'updated_at' => time(),
                'type_id' => User::TYPE_ID_STUDENT
            ];
        } else {
            $data = [
                'full_name' => $row['A'] ?? '',
                'sex' => $sex,
                'born_date' => $row['C'] ?? '',
                'jshshir' => $jshshir,
                'course_id' => $course ? $course->id : null,
                'language_id' => $language ? $language->id : null,
                'direction_id' => $direction ? $direction->id : null,
                'faculty_id' => $direction ? $direction->faculty_id : null,
                'educational_type' => $educationalType,
                'educational_form' => $educationalForm,
                'username' => $jshshir,
                'simple_password' => $jshshir,
                'created_at' => time(),
                'updated_at' => time(),
                'type_id' => User::TYPE_ID_STUDENT
            ];
        }

        if (!$course || !$direction || !$language || !$educationalType || !$educationalForm || !$sex || ($action !== 'import' && !isset($this->existingUsers[$jshshir]))) {
            $result['success'] = false;
            $result['errors'] = [
                'jshshir' => !$jshshir ? "<i class='badge badge-danger'>$jshshir</i>" : $jshshir,
                'course' => !$course ? "<i class='badge badge-danger'>{$row['E']}</i>" : $row['E'],
                'direction' => !$direction ? "<i class='badge badge-danger'>{$row['G']}</i>" : $row['G'],
                'language' => !$language ? "<i class='badge badge-danger'>{$row['F']}</i>" : $row['F'],
                'educational_type' => !$educationalType ? "<i class='badge badge-danger'>{$row['H']}</i>" : $row['H'],
                'educational_form' => !$educationalForm ? "<i class='badge badge-danger'>{$row['I']}</i>" : $row['I'],
                'sex' => !$sex ? "<i class='badge badge-danger'>{$row['B']}</i>" : $row['B'],
            ];
        } elseif (($action === 'import' && isset($this->existingUsers[$jshshir]))) {
            $result['success'] = false;
        } else {
            $result['data'] = $data;
        }
        return $result;
    }

    private function batchSave($inserts, $updates, $action)
    {
        if (!empty($inserts)) {
            Yii::$app->db->createCommand()
                ->batchInsert('user', ['full_name', 'sex', 'born_date', 'jshshir', 'course_id', 'language_id', 'direction_id', 'faculty_id', 'educational_type', 'educational_form', 'username', 'simple_password', 'created_at', 'updated_at', 'type_id'], $inserts)
                ->execute();
        }

        if (!empty($updates)) {
            if ($action == 'update') {
                $this->batchUpdateUsers($updates);
            } elseif ($action == 'delete') {
                $this->batchDeleteUsers($updates);
            }
        }
    }

    private function batchUpdateUsers(array $userUpdates): void
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            foreach ($userUpdates as $update) {
                $user = User::findOne($update['id']);
                $user->course_id = $update['course_id'];
                $user->language_id = $update['language_id'];
                $user->direction_id = $update['direction_id'];
                $user->faculty_id = $update['faculty_id'];
                $user->educational_type = $update['educational_type'];
                $user->educational_form = $update['educational_form'];
                $user->updated_at = $update['updated_at'];
                $user->save(false); // Save without validation for performance
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    private function batchDeleteUsers(array $userUpdates): void
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            foreach ($userUpdates as $update) {
                $user = User::findOne($update['id']);
                $user->status = User::STATUS_INACTIVE;
                $user->auth_key = $user->auth_key . '_' . $user['id'];
                $user->save(false); // Save without validation for performance
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    function cleanString($string)
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }
}
