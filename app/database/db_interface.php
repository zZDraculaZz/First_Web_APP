<?php
interface DBInterface
{
    // singleton
    public static function get_instance($db_name);
    // искать данные
    public function search_data($column, $table_name, $column2, $column2_id);
    // вставить данные в таблицу | хочу использовать через параметры
    public function insert_data($table_name,$params=[]);
    // получить всю таблицу
    public function get_all_table($table_name);
    // получить данные с таблицы с помощью параметров | хочу использовать через параметры
    public function take_data($select,$table_name,$params=[],$add_params=[]);
    // возвращает данные в виде списка, из таблицы по айди колонки
    public function get_array_data($table_name,$column,$column_id);
    // возвращает строку таблицы по ее id
    public function get_data($column,$table_name,$column2,$column2_id);
    // создает пользователя
    public function create_user($email,$login,$password,$admin);
    // обновляет данные
    public function update_data($table_name, $column1, $data, $column2, $column2_id);
    // удаляет
    public function delete_data($table,$column,$column_id);

}