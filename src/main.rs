extern crate sysfs_gpio;

use std::env;
use sysfs_gpio::{Direction, Pin};

fn main() {
    let pin_num_arg = env::args().nth(1).expect("Expected a first argument");
    let direction_arg = env::args().nth(2).expect("Expected a second argument");

    let pin_num = parse_pin_number(pin_num_arg);
    let direction = parse_direction(direction_arg);

    let my_pin = Pin::new(pin_num);

    let result = my_pin.with_exported(|| {
        my_pin.set_direction(direction)?;
        return Ok(());
    });

    match result {
        Ok(_) => println!("Did it"),
        Err(err) => println!("fucked up, {}", err),
    }
}

fn parse_pin_number(str: String) -> u64 {
    let pin_number: u64 = str.parse().unwrap();

    return pin_number;
}

fn parse_direction(str: String) -> Direction {
    if str == "in" {
        return Direction::In;
    } else if str == "out" {
        return Direction::Out;
    } else {
        panic!("Direction must match in or out");
    }
}
