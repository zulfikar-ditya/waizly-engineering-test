"use client";
// TodoList.tsx
import React from "react";
import { useSelector, useDispatch } from "react-redux";
import { addTodo } from "../redux/todoSlice";
import Todo from "./Todo";
import { TodoState } from "../redux/todoTypes";

const TodoList: React.FC = () => {
	const dispatch = useDispatch();
	const todos = useSelector<TodoState>((state) => state.todos);

	const handleAddTodo = (event: React.FormEvent<HTMLFormElement>) => {
		event.preventDefault();
		const text = (event.target.elements.newTodo as HTMLInputElement).value;
		if (text) {
			dispatch(addTodo(text));
			(event.target.elements.newTodo as HTMLInputElement).value = "";
		}
	};

	return (
		<div>
			<form onSubmit={handleAddTodo}>
				<input type="text" name="newTodo" placeholder="Add a new todo" />
				<button type="submit">Add</button>
			</form>
			<ul>
				{/* {Object.keys(todos).length > 0 &&
					Object.keys(todos).map((key) => <Todo key={key} todo={todos[key]} />)} */}
			</ul>
		</div>
	);
};

export default TodoList;
