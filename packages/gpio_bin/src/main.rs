extern crate sysfs_gpio;

use anyhow::{anyhow, Context, Result};
use std::{env, thread::sleep, time};
use sysfs_gpio::{Direction, Pin};

fn main() -> Result<()> {
    let pin_num_arg = env::args()
        .nth(1)
        .ok_or(anyhow!("Argument 1 must be specified"))?;
    let direction_arg = env::args()
        .nth(2)
        .ok_or(anyhow!("Argument 2 must be specified"))?;

    let pin_num = pin_num_arg.parse::<u64>()?;
    let direction = parse_direction(&direction_arg)?;

    let my_pin = Pin::new(pin_num);

    let result = my_pin.with_exported(|| {
        sleep(time::Duration::from_millis(80));
        my_pin.set_direction(direction)?;
        return Ok(());
    });

    result.context("Tried setting pins")
}

fn parse_direction(str: &str) -> Result<Direction, anyhow::Error> {
    match str {
        "in" => Ok(Direction::In),
        "out" => Ok(Direction::Out),
        _ => Err(anyhow!(
            "Invalid Direction: Must be either in or out".to_string()
        )),
    }
}
