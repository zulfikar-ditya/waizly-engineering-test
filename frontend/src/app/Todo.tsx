// Todo.tsx
import React from "react";
import { useDispatch, useSelector } from "react-redux";
import { Todo } from "../redux/todoTypes";
import { editTodo, deleteTodo, toggleCompleted } from "../redux/todoSlice";

const Todo: React.FC<Todo> = ({ todo }) => {
	const dispatch = useDispatch();

	const handleEdit = (event: React.ChangeEvent<HTMLInputElement>) => {
		dispatch(editTodo({ id: todo.id, text: event.target.value }));
	};

	const handleDelete = () => {
		dispatch(deleteTodo(todo.id));
	};

	const handleToggleCompleted = () => {
		dispatch(toggleCompleted(todo.id));
	};

	return (
		<li className={`todo-item ${todo.completed ? "completed" : ""}`}>
			<input
				type="checkbox"
				checked={todo.completed}
				onChange={handleToggleCompleted}
			/>
			<input
				type="text"
				value={todo.text}
				onChange={handleEdit}
				onBlur={handleEdit}
			/>
			<button onClick={handleDelete}>Delete</button>
		</li>
	);
};

export default Todo;
